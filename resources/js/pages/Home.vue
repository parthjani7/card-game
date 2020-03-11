<template>
    <div>
        <b-form>
            <b-form-group
                id="input-group-2"
                label="Your Fullname:"
                label-for="input-2"
            >
                <b-form-input
                    id="input-2"
                    v-model="form.full_name"
                    required
                    placeholder="Enter Your Fullname"
                ></b-form-input>
            </b-form-group>

            <b-form-group
                id="input-group-2"
                label="Enter your choice of cards, card should be separated by a space:"
                label-for="input-2"
            >
                <b-form-input
                    id="input-2"
                    v-model="form.cards"
                    required
                    placeholder="2 3 4 Q K"
                ></b-form-input>
            </b-form-group>

            <b-button type="button" @click="play" variant="primary"
                >Start Game</b-button
            >
            &nbsp;
            <b-button type="reset" @click="reset" variant="danger"
                >Reset</b-button
            >
        </b-form>
        <b-card class="mt-3" header="Score Board">
            <h6>Player’s hand: {{ user_cards }}</h6>
            <h6>Generated Hand: {{ auto_generated_cards }}</h6>
            <hr />
            <h4>Calculated Score</h4>
            <hr />
            <h6>Player: {{ score.player || 0 }}</h6>
            <h6>Generated: {{ score.generated || 0 }}</h6>
        </b-card>
    </div>
</template>

<script>
export default {
    name: "Home",

    data() {
        return {
            form: {
                full_name: "",
                cards: ""
            },
            auto_generated_cards: [],
            score: {
                player: 0,
                generated: 0
            }
        };
    },
    computed: {
        user_cards() {
            return (
                this.form.cards &&
                this.form.cards.split(" ").filter(el => el != "")
            );
        }
    },
    methods: {
        play() {
            this.$axios
                .post(
                    "/api/v1/play",
                    { ...this.form, cards: this.user_cards },
                    {
                        headers: {
                            Accept: "application/json"
                        }
                    }
                )
                .then(response => {
                    console.log(response.data);
                    if (response.data) {
                        this.auto_generated_cards =
                            response.data.auto_generated_cards;
                        this.score = response.data.score;
                    }
                });
        },
        reset() {
            // Reset form values
            this.form = {};
            this.auto_generated_cards = [];
            this.score = {};
        }
    }
};
</script>

<style></style>
