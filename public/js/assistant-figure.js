/**
 * Kukta assistant figure (Lottie animation) with a speech bubble. lottie-web must be loaded first.
 * The frames of each move are given by the markers of the animation JSON (idle, hello, goodbye).
 *
 * @param {HTMLElement} root element containing an .assistant-figure-anim and an .assistant-figure-bubble element
 * @param {Object} animationData the animation JSON
 * @returns {{hello: function(string=): Promise, goodbye: function(string=): Promise, sayHello: function(): void, destroy: function(): void}}
 *          hello: waves and greets, goodbye: says goodbye, sayHello: shows the greeting text without moving
 */
function createAssistant(root, animationData) {
    const HELLO_TEXT = 'Szia!\nÉn vagyok az asszisztensed.\nInduljon a főzés!';
    const bubble = root.querySelector('.assistant-figure-bubble');
    const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const segments = Object.fromEntries(animationData.markers.map(marker => [marker.cm, [marker.tm, marker.tm + marker.dr]]));
    const animation = lottie.loadAnimation({
        container: root.querySelector('.assistant-figure-anim'),
        renderer: 'svg',
        loop: true,
        autoplay: false,
        animationData: animationData,
    });
    let bubbleTimer;
    let onMoveComplete = null;

    /**
     * Idle state: looping "breathing" (a still frame with reduced motion).
     */
    function idle() {
        if (reduced) {
            animation.goToAndStop(0, true);
            return;
        }
        animation.loop = true;
        animation.playSegments(segments.idle, true);
    }

    /**
     * Plays a move with the given bubble text, then returns to the idle state.
     *
     * @returns {Promise} resolved when the move ends
     */
    function play(name, text, bubbleDelay) {
        clearTimeout(bubbleTimer);
        bubble.classList.remove('is-visible');
        bubble.textContent = text;
        if (reduced) {
            bubble.classList.add('is-visible');
            return Promise.resolve();
        }
        bubbleTimer = setTimeout(() => bubble.classList.add('is-visible'), bubbleDelay);
        animation.loop = false;
        animation.playSegments(segments[name], true);
        return new Promise(resolve => {
            onMoveComplete = resolve;
        });
    }

    /**
     * Replaces the bubble text without moving.
     */
    function say(text) {
        clearTimeout(bubbleTimer);
        bubble.textContent = text;
        bubble.classList.add('is-visible');
    }

    animation.addEventListener('DOMLoaded', idle);
    animation.addEventListener('complete', () => {
        idle();
        if (onMoveComplete) {
            const resolve = onMoveComplete;
            onMoveComplete = null;
            resolve();
        }
    });

    return {
        hello: (text = HELLO_TEXT) => play('hello', text, 500),
        goodbye: (text = 'Jó étvágyat!') => play('goodbye', text, 300),
        sayHello: () => say(HELLO_TEXT),
        destroy: () => animation.destroy(),
    };
}
