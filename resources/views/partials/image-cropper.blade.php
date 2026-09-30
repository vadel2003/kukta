{{-- Közös képvágó ablak (Profil: profilkép, Recept űrlap: saját kép).
     Használat: az oldal saját script blokkja ELÉ kell behúzni (include), majd ott meghívni
     a setupImageCropper függvényt. A formon KÍVÜLRE kerüljön: a kész (levágott) képet a JS
     teszi vissza a form file inputjába. Egy oldalon egy vágó lehet. --}}
<div id="imageCropModal" class="modal">
    <div class="modal-content modal-small modal-crop">
        <div class="modal-header">
            <h3>Kép vágása</h3>
            <button type="button" class="close-btn" onclick="closeModal('imageCropModal')">&times;</button>
        </div>
        <div class="modal-body">
            <div class="crop-stage" id="crop-stage">
                <img id="crop-image" alt="">
            </div>
            <label for="crop-zoom" class="crop-zoom-label">Nagyítás</label>
            <input type="range" id="crop-zoom" class="crop-zoom" min="1" max="3" step="0.01" value="1">
            <p class="field-hint">Húzd a képet a megfelelő helyre.</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-outline" onclick="closeModal('imageCropModal')">Mégse</button>
            <button type="button" class="btn-cook btn-cook-primary" id="crop-apply">Alkalmaz</button>
        </div>
    </div>
</div>

<script>
    // A kiválasztott képet nem küldjük el eredetiben: a böngészőben vágjuk ki,
    // kicsinyítjük a kért méretre és tömörítjük, és csak ez a kis kép megy a szerverre.
    //
    // options:
    //   input   - a file input elem, amit figyelünk
    //   width   - a kész kép szélessége pixelben
    //   height  - a kész kép magassága pixelben
    //   quality - JPEG tömörítés: 0 (kicsi fájl, csúnya) - 1 (nagy fájl, szép)
    //   round   - true: kör alakú maszk a vágóterületen (profilkép)
    //   onApply - "Alkalmaz" után hívjuk meg a kész képpel (blob), pl. előnézet frissítéséhez
    // Visszaad egy objektumot, aminek a clear() függvénye kiüríti a file inputot.
    function setupImageCropper(options) {
        const input = options.input;
        const cropStage = document.getElementById('crop-stage');
        const cropImage = document.getElementById('crop-image');
        const cropZoom = document.getElementById('crop-zoom');

        // A vágóterület alakja = a kész kép alakja (pl. 100x100 -> négyzet, 1200x800 -> fekvő)
        cropStage.style.aspectRatio = options.width + ' / ' + options.height;
        cropStage.classList.toggle('crop-stage--round', options.round === true);

        // A file input "jóváhagyott" tartalma: üres, vagy a legutóbb levágott kép.
        // (A DataTransfer az egyetlen mód arra, hogy JS-ből fájllistát készítsünk.)
        let appliedFiles = new DataTransfer().files;

        let stageW = 0;     // a vágóterület mérete a képernyőn (px)
        let stageH = 0;
        let baseScale = 1;  // ennyivel szorozva a kép éppen kitölti a vágóterületet
        let scale = 1;      // aktuális méretarány (baseScale * csúszka értéke)
        let posX = 0;       // a kép bal felső sarkának helye a vágóterületen belül
        let posY = 0;

        function drawCropImage() {
            // A kép nem húzható ki a keretből: a bal széle legfeljebb 0-nál lehet,
            // a jobb széle pedig legalább a keret jobb szélénél (ugyanez függőlegesen)
            posX = Math.min(0, Math.max(stageW - cropImage.naturalWidth * scale, posX));
            posY = Math.min(0, Math.max(stageH - cropImage.naturalHeight * scale, posY));
            cropImage.style.width = cropImage.naturalWidth * scale + 'px';
            cropImage.style.transform = 'translate(' + posX + 'px, ' + posY + 'px)';
        }

        input.addEventListener('change', function () {
            const file = input.files[0];
            // Az inputot rögtön visszaállítjuk a jóváhagyott állapotra: így ha a vágó
            // ablakot bárhogy bezárják (Mégse, X, háttérre kattintás), a nagy eredeti
            // kép biztosan nem kerül elküldésre
            input.files = appliedFiles;
            if (!file) return;

            cropImage.onload = function () {
                // Előbb nyitjuk meg az ablakot, mert rejtett elemnek 0 a mérete
                openModal('imageCropModal');
                stageW = cropStage.clientWidth;
                stageH = cropStage.clientHeight;
                // A kép mindkét irányban töltse ki a keretet (mint a CSS object-fit: cover),
                // ezért a két arány közül a nagyobbik kell
                baseScale = Math.max(stageW / cropImage.naturalWidth, stageH / cropImage.naturalHeight);
                scale = baseScale;
                cropZoom.value = 1;
                // Induláskor a kép közepe látszik
                posX = (stageW - cropImage.naturalWidth * scale) / 2;
                posY = (stageH - cropImage.naturalHeight * scale) / 2;
                drawCropImage();
            };
            cropImage.onerror = function () {
                alert('Ezt a fájlt nem sikerült képként megnyitni.');
            };
            cropImage.src = URL.createObjectURL(file);
        });

        // Nagyítás: a keret közepén lévő képpont maradjon a helyén, ne a bal felső sarok
        cropZoom.addEventListener('input', function () {
            const centerX = (stageW / 2 - posX) / scale;
            const centerY = (stageH / 2 - posY) / scale;
            scale = baseScale * cropZoom.value;
            posX = stageW / 2 - centerX * scale;
            posY = stageH / 2 - centerY * scale;
            drawCropImage();
        });

        // Húzás: pointer események = egér és érintés egy kódban
        let dragStart = null;
        cropStage.addEventListener('pointerdown', function (e) {
            dragStart = { x: e.clientX - posX, y: e.clientY - posY };
            // A húzás akkor is folytatódjon, ha a mutató kicsúszik a keretből
            cropStage.setPointerCapture(e.pointerId);
        });
        cropStage.addEventListener('pointermove', function (e) {
            if (!dragStart) return;
            posX = e.clientX - dragStart.x;
            posY = e.clientY - dragStart.y;
            drawCropImage();
        });
        cropStage.addEventListener('pointerup', function () { dragStart = null; });
        cropStage.addEventListener('pointercancel', function () { dragStart = null; });

        document.getElementById('crop-apply').addEventListener('click', function () {
            const canvas = document.createElement('canvas');
            canvas.width = options.width;
            canvas.height = options.height;
            const ctx = canvas.getContext('2d');
            // Fehér háttér: a JPEG nem ismer átlátszóságot, enélkül az átlátszó részek feketék lennének
            ctx.fillStyle = '#fff';
            ctx.fillRect(0, 0, options.width, options.height);
            ctx.imageSmoothingQuality = 'high';
            // Az eredeti képből a keretben látható részt rajzoljuk át a canvasra.
            // A képernyő-pixeleket a scale-lel osztva kapjuk vissza az eredeti kép pixeleit.
            ctx.drawImage(
                cropImage,
                -posX / scale, -posY / scale, stageW / scale, stageH / scale,
                0, 0, options.width, options.height
            );

            canvas.toBlob(function (blob) {
                const transfer = new DataTransfer();
                transfer.items.add(new File([blob], 'image.jpg', { type: 'image/jpeg' }));
                appliedFiles = transfer.files;
                input.files = appliedFiles;

                closeModal('imageCropModal');
                options.onApply(blob);
            }, 'image/jpeg', options.quality);
        });

        return {
            clear: function () {
                appliedFiles = new DataTransfer().files;
                input.files = appliedFiles;
            },
        };
    }
</script>
