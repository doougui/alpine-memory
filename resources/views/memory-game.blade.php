<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>Memory Game</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <div x-data="game()" x-init="sort()" class="px-10 flex items-center justify-center min-h-screen">
        <h1 class="fixed top-0 right-0 p-10 font-bold text-3xl">
            <span x-text="points"></span>
            <span class="text-xs">pts</span>
        </h1>

        <div class="flex-1 grid grid-cols-4 gap-10">
            <template x-for="card in cards">
                <div>
                    <button
                        x-show="! card.cleared"
                        :style="'background: ' + (card.flipped ? card.color : '#999')"
                        class="w-full h-32"
                        @click="flipCard(card)"
                    ></button>
                </div>
            </template>
        </div>
    </div>

    {{--flash messages--}}
    <div
        x-data="{ show: false, message: '' }"
        x-show.transition.opacity="show"
        x-text="message"
        @flash.window="
            message = $event.detail.message;
            show = true;
            setTimeout(() => show = false, 1000)
        "
        class="fixed bottom-0 right-0 bg-green-500 text-white p-2 mb-4 mr-4 rounded"
    >
    </div>

    <script>
        function pause(milliseconds = 1000) {
            return new Promise(resolve => setTimeout(resolve, milliseconds));
        }

        function flash(message) {
            window.dispatchEvent(new CustomEvent('flash', {
                detail: { message }
            }));
        }

        function game() {
            return {
                cards: [
                    { color: 'green', flipped: false, cleared: false },
                    { color: 'red', flipped: false, cleared: false },
                    { color: 'blue', flipped: false, cleared: false },
                    { color: 'yellow', flipped: false, cleared: false },
                    { color: 'green', flipped: false, cleared: false },
                    { color: 'red', flipped: false, cleared: false },
                    { color: 'blue', flipped: false, cleared: false },
                    { color: 'yellow', flipped: false, cleared: false },
                ],

                sort() {
                  this.cards.sort(() => Math.random() - .5);
                },

                get flippedCards() {
                    return this.cards.filter(card => card.flipped);
                },

                get clearedCards() {
                    return this.cards.filter(card => card.cleared);
                },

                get remainingCards() {
                    return this.cards.filter(card => ! card.cleared);
                },

                get points() {
                    return this.clearedCards.length;
                },

                async flipCard(card) {
                    if (this.flippedCards.length === 2) {
                        return;
                    }

                    card.flipped = ! card.flipped;

                    if (this.flippedCards.length === 2) {
                        if (this.hasMatch()) {
                            flash('You found a match!');
                            await pause();

                            this.flippedCards.forEach(card => card.cleared = true);

                            if (! this.remainingCards.length) {
                                alert('You won!');

                                this.reset();
                            }
                        }

                        await pause();

                        this.flippedCards.forEach(card => card.flipped = false);
                    }
                },

                hasMatch() {
                    return this.flippedCards[0]['color'] === this.flippedCards[1]['color'];
                },

                reset() {
                    this.cards.forEach(card => {
                        card.flipped = false;
                        card.cleared = false;
                    });
                    this.sort();
                }
            };
        }
    </script>
</body>
</html>
