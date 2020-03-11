<template>
    <div>
        <validation-observer ref="observer">
            <b-form>
                <validation-provider
                    name="FullName"
                    :rules="{ required: true, min: 3 }"
                    v-slot="validationContext"
                >
                    <b-form-group
                        id="input-group-2"
                        label="Your Fullname:"
                        label-for="input-2"
                    >
                        <b-form-input
                            id="input-2"
                            v-model="form.full_name"
                            :class="errors.full_name ? 'is-invalid' : ''"
                            :validate="{ required: true, min: 3 }"
                            :state="getValidationState(validationContext)"
                            placeholder="Enter Your Fullname"
                        ></b-form-input>
                        <b-form-invalid-feedback id="input-1-live-feedback">{{
                            error_messages.full_name
                        }}</b-form-invalid-feedback>
                    </b-form-group>
                </validation-provider>

                <validation-provider
                    name="Cards"
                    :rules="{ required: true }"
                    v-slot="validationContext"
                >
                    <b-form-group
                        id="input-group-2"
                        label="Enter your choice of cards, card should be separated by a space:"
                        label-for="input-2"
                    >
                        <b-form-input
                            id="input-2"
                            v-model="form.cards"
                            :validate="{
                                required: true,
                                regex: /^(([2-9,J,A,K,Q]\d{1})\ )$/
                            }"
                            :class="errors.cards ? 'is-invalid' : ''"
                            :state="getValidationState(validationContext)"
                            placeholder="2 3 4 Q K"
                        ></b-form-input>
                        <b-form-invalid-feedback id="input-1-live-feedback">{{
                            error_messages.cards
                        }}</b-form-invalid-feedback>
                    </b-form-group>
                </validation-provider>
                <b-button type="button" @click="playNow" variant="primary"
                    >Play Now</b-button
                >
                &nbsp;
                <b-button type="reset" @click="resetForm" variant="danger"
                    >Reset</b-button
                >
            </b-form>
        </validation-observer>
        <b-card class="mt-3" header="Score Board">
            <h6>Player’s hand: {{ user_cards }}</h6>
            <h6>Generated Hand: {{ generated_cards }}</h6>
            <hr />
            <h4>Calculated Score</h4>
            <hr />
            <h6>Player: {{ score.player || 0 }}</h6>
            <h6>Generated: {{ score.generated || 0 }}</h6>
        </b-card>
        <hr />
        <p class="bg-warning p-2">
            If User and Generated both are 0, then the game is Tie
        </p>
        <b-card class="mt-3" header="Game History">
            <b-table striped hover :items="games" :fields="fields"></b-table>
        </b-card>
    </div>
</template>

<script>
export default {
    name: "Home",

    data() {
        return {
            form: {
                full_name: null,
                cards: null
            },
            generated_cards: [],
            score: {
                player: 0,
                generated: 0
            },
            errors: {
                cards: false,
                full_name: false
            },
            error_messages: {
                cards: "Card Data is Invalid",
                full_name: "Fullname is Invalid"
            },
            fields: [
                { key: "user.full_name", label: "Full Name" },
                { key: "user_cards", label: "User's Cards" },
                { key: "generated_cards", label: "Generated Cards" },
                {
                    key: "is_user_won",
                    label: "User Won?"
                },
                { key: "is_machine_won", label: "Generated Won?" },
                { key: "created_at", label: "Created" }
            ],
            games: []
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
        getValidationState({ dirty, validated, valid = null }) {
            return dirty || validated ? valid : null;
        },
        async playNow() {
            const is_valid = await this.$refs.observer.validate();
            if (!is_valid) return;
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
                    if (response.data) {
                        this.resetErrors();
                        this.generated_cards = response.data.generated_cards;
                        this.score = response.data.score;
                        this.fetchGamesHistory();
                    }
                })
                .catch(err => {
                    if (err.response.status === 422) {
                        this.errors.cards = true;
                        this.error_messages.cards = err.response.errors.cards;
                        this.errors.full_name = true;
                        this.error_messages.full_name =
                            err.response.errors.full_name;
                    }
                });
        },
        fetchGamesHistory() {
            this.$axios
                .get("/api/v1/play", {
                    headers: {
                        Accept: "application/json"
                    }
                })
                .then(response => {
                    if (response.data) {
                        console.log(response.data);
                        this.games = response.data;
                    }
                });
        },
        resetForm() {
            // Reset form values
            this.form = {};
            this.resetScore();
            this.resetErrors();
        },
        resetScore() {
            this.generated_cards = [];
            this.score = {};
        },
        resetErrors() {
            this.errors = {};
            this.error_messages = {};
        }
    },
    mounted() {
        this.fetchGamesHistory();
    }
};
</script>

<style></style>
