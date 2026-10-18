// Kukta asszisztens figura (Lottie) + szóbuborék.
// A lottie-web-et (globális "lottie") ELŐTTE kell betölteni.
//
// Használat:
//   const figure = createAssistant(rootElem, animationData);
//   figure.hello();    // integet + "Szia!..." buborék
//   figure.goodbye();  // elköszön + "Jó étvágyat!" buborék
//   figure.sayHello(); // csak a "Szia!..." szöveg, mozdulat nélkül
//
// A rootElem-ben kell lennie egy .assistant-figure-anim és egy .assistant-figure-bubble elemnek.
// Az animáció JSON-jában lévő markerek (idle, hello, goodbye) adják meg, melyik képkockák tartoznak
// az egyes mozdulatokhoz - így a JS-nek nem kell képkocka-számokat tudnia.
function createAssistant(root, animationData) {
    const bubble = root.querySelector('.assistant-figure-bubble');
    const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    // { idle: [0, 96], hello: [100, 244], goodbye: [250, 340] }
    const seg = Object.fromEntries(animationData.markers.map(m => [m.cm, [m.tm, m.tm + m.dr]]));
    const anim = lottie.loadAnimation({
        container: root.querySelector('.assistant-figure-anim'),
        renderer: 'svg',
        loop: true,
        autoplay: false,
        animationData: animationData,
    });
    let bubbleTimer;
    let done = null;

    // Alapállapot: ismétlődő "lélegzés". Csökkentett mozgásnál álló kép a 0. képkockán.
    function idle() {
        if (reduced) { anim.goToAndStop(0, true); return; }
        anim.loop = true;
        anim.playSegments(seg.idle, true);
    }

    // Egy mozdulat (hello/goodbye) végén: vissza idle-be. A buborék látva marad a figura
    // mellett (csak a következő mozdulat cseréli le a szövegét)
    anim.addEventListener('complete', () => {
        idle();
        if (done) { const d = done; done = null; d(); }
    });

    function play(name, text, bubbleDelay) {
        clearTimeout(bubbleTimer);
        bubble.classList.remove('is-visible');
        bubble.textContent = text;
        if (reduced) {
            // Csökkentett mozgás: nincs animáció, csak a buborék jelenik meg (és látva marad)
            bubble.classList.add('is-visible');
            return Promise.resolve();
        }
        bubbleTimer = setTimeout(() => bubble.classList.add('is-visible'), bubbleDelay);
        anim.loop = false;
        anim.playSegments(seg[name], true);
        return new Promise(resolve => { done = resolve; });
    }

    anim.addEventListener('DOMLoaded', idle);

    // Csak a buborék szövegét cseréli le, mozdulat (animáció) nélkül
    function say(text) {
        clearTimeout(bubbleTimer);
        bubble.textContent = text;
        bubble.classList.add('is-visible');
    }

    const HELLO_TEXT = 'Szia!\nÉn vagyok az asszisztensed.\nInduljon a főzés!';

    return {
        hello: (text = HELLO_TEXT) => play('hello', text, 500),
        goodbye: (text = 'Jó étvágyat!') => play('goodbye', text, 300),
        // A nyitó képernyőre visszalapozva újra a köszönő szöveg látszik (integetés nélkül)
        sayHello: () => say(HELLO_TEXT),
        destroy: () => anim.destroy(),
    };
}
