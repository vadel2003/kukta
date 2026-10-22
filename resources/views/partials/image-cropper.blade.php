{{-- Image crop dialog (avatar, recipe image). Include it outside the form, before the page script,
     then connect it with setupImageCropper(). Only one cropper per page. --}}
<div id="imageCropModal" class="modal">
    <div class="modal-content modal-small modal-crop">
        <div class="modal-header">
            <h3>Kép vágása</h3>
            <button type="button" class="close-btn" data-modal-close>&times;</button>
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
            <button type="button" class="btn-outline" data-modal-close>Mégse</button>
            <button type="button" class="btn-cook btn-cook-primary" id="crop-apply">Alkalmaz</button>
        </div>
    </div>
</div>

<script>
    /**
     * Image cropper for a file input: the selected image is cropped, resized and compressed to JPEG
     * in the browser, and this image is put back into the file input (the original is never uploaded).
     *
     * @param {Object} options
     * @param {HTMLInputElement} options.input the file input
     * @param {number} options.width width of the resulting image (px)
     * @param {number} options.height height of the resulting image (px)
     * @param {number} options.quality JPEG quality, 0-1
     * @param {boolean} [options.round] round crop area (avatar)
     * @param {function(Blob): void} options.onApply called with the resulting image after Apply
     * @returns {Object} with a clear() function that empties the file input
     */
    function setupImageCropper(options) {
        const input = options.input;
        const cropStage = document.getElementById('crop-stage');
        const cropImage = document.getElementById('crop-image');
        const cropZoom = document.getElementById('crop-zoom');

        cropStage.style.aspectRatio = options.width + ' / ' + options.height;
        cropStage.classList.toggle('crop-stage--round', options.round === true);

        let appliedFiles = new DataTransfer().files;
        let stageWidth = 0;
        let stageHeight = 0;
        let baseScale = 1;
        let scale = 1;
        let posX = 0;
        let posY = 0;
        let dragStart = null;

        /**
         * Draws the image at the current scale and position, keeping it inside the crop area.
         */
        function drawCropImage() {
            posX = Math.min(0, Math.max(stageWidth - cropImage.naturalWidth * scale, posX));
            posY = Math.min(0, Math.max(stageHeight - cropImage.naturalHeight * scale, posY));
            cropImage.style.width = cropImage.naturalWidth * scale + 'px';
            cropImage.style.transform = 'translate(' + posX + 'px, ' + posY + 'px)';
        }

        input.addEventListener('change', () => {
            const file = input.files[0];
            input.files = appliedFiles;
            if (!file) return;

            cropImage.onload = () => {
                openModal('imageCropModal');
                stageWidth = cropStage.clientWidth;
                stageHeight = cropStage.clientHeight;
                baseScale = Math.max(stageWidth / cropImage.naturalWidth, stageHeight / cropImage.naturalHeight);
                scale = baseScale;
                cropZoom.value = 1;
                posX = (stageWidth - cropImage.naturalWidth * scale) / 2;
                posY = (stageHeight - cropImage.naturalHeight * scale) / 2;
                drawCropImage();
            };
            cropImage.onerror = () => {
                alert('Ezt a fájlt nem sikerült képként megnyitni.');
            };
            cropImage.src = URL.createObjectURL(file);
        });

        cropZoom.addEventListener('input', () => {
            const centerX = (stageWidth / 2 - posX) / scale;
            const centerY = (stageHeight / 2 - posY) / scale;
            scale = baseScale * cropZoom.value;
            posX = stageWidth / 2 - centerX * scale;
            posY = stageHeight / 2 - centerY * scale;
            drawCropImage();
        });

        cropStage.addEventListener('pointerdown', event => {
            dragStart = { x: event.clientX - posX, y: event.clientY - posY };
            cropStage.setPointerCapture(event.pointerId);
        });
        cropStage.addEventListener('pointermove', event => {
            if (!dragStart) return;
            posX = event.clientX - dragStart.x;
            posY = event.clientY - dragStart.y;
            drawCropImage();
        });
        cropStage.addEventListener('pointerup', () => {
            dragStart = null;
        });
        cropStage.addEventListener('pointercancel', () => {
            dragStart = null;
        });

        document.getElementById('crop-apply').addEventListener('click', () => {
            const canvas = document.createElement('canvas');
            canvas.width = options.width;
            canvas.height = options.height;
            const context = canvas.getContext('2d');
            context.fillStyle = '#fff';
            context.fillRect(0, 0, options.width, options.height);
            context.imageSmoothingQuality = 'high';
            context.drawImage(
                cropImage,
                -posX / scale, -posY / scale, stageWidth / scale, stageHeight / scale,
                0, 0, options.width, options.height
            );

            canvas.toBlob(blob => {
                const transfer = new DataTransfer();
                transfer.items.add(new File([blob], 'image.jpg', { type: 'image/jpeg' }));
                appliedFiles = transfer.files;
                input.files = appliedFiles;

                closeModal('imageCropModal');
                options.onApply(blob);
            }, 'image/jpeg', options.quality);
        });

        return {
            clear: () => {
                appliedFiles = new DataTransfer().files;
                input.files = appliedFiles;
            },
        };
    }
</script>
