<template>
    <div>
        <div class="grid grid-flow-col gap-4">
            <div class="col-span-1">
                <league-component v-bind:data="league"></league-component>
            </div>
            <div class="col-span-1">
                <match-component v-bind:data="match" v-bind:weekNo="weekNo"></match-component>
            </div>
            <div class="col-span-1">
                <prediction-component v-bind:data="prediction" v-bind:weekNo="weekNo"></prediction-component>
            </div>
        </div>
        <div class="text-center mt-5">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-40" id="js-btn-play-all" v-on:click="playAll">
                Play All
            </button>
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" id="js-btn-next-week" v-on:click="nextWeek">
                Next Week
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                league: [
                    {"team":"Manchester City","pts":0,"p":0,"w":0,"d":0,"l":0,"gd":0},
                    {"team":"Arsenal","pts":0,"p":0,"w":0,"d":0,"l":0,"gd":0},
                    {"team":"Liverpool","pts":0,"p":0,"w":0,"d":0,"l":0,"gd":0},
                    {"team":"Chelsea","pts":0,"p":0,"w":0,"d":0,"l":0,"gd":0}
                ],
                match: [],
                prediction: [],
                weekNo: '0'
            }
        },
        methods: {
            playAll() {
                axios.post('/playAll', {
                    _token: document.getElementById("js-csrf-token").value,
                    week_no: document.getElementById("js-week-no").value,
                    league_token: document.getElementById("js-league-token").value
                })
                .then((response)=>{
                    this.weekNo = response.data.week_no;
                    this.league = response.data.ranking;
                    this.match = response.data.results;
                    this.prediction = response.data.prediction;
                    document.getElementById("js-week-no").value = 0;
                    document.getElementById('js-btn-play-all').setAttribute("disabled", "disabled");
                    document.getElementById('js-btn-next-week').setAttribute("disabled", "disabled");
                    document.getElementById('js-btn-play-all').classList.add('cursor-not-allowed');
                    document.getElementById('js-btn-play-all').classList.add('opacity-50');
                    document.getElementById('js-btn-next-week').classList.add('cursor-not-allowed');
                    document.getElementById('js-btn-next-week').classList.add('opacity-50');
                });
            },
            nextWeek() {
                axios.post('/doNextMatch', {
                    _token: document.getElementById("js-csrf-token").value,
                    week_no: document.getElementById("js-week-no").value,
                    league_token: document.getElementById("js-league-token").value,
                })
                .then((response)=>{
                    this.weekNo = response.data.week_no;
                    this.league = response.data.ranking;
                    this.match = response.data.results;
                    this.prediction = response.data.prediction;
                    if (parseInt(response.data.week_no) > 5) {
                        document.getElementById("js-week-no").value = 0;
                        document.getElementById('js-btn-play-all').setAttribute("disabled", "disabled");
                        document.getElementById('js-btn-next-week').setAttribute("disabled", "disabled");
                        document.getElementById('js-btn-play-all').classList.add('cursor-not-allowed');
                        document.getElementById('js-btn-play-all').classList.add('opacity-50');
                        document.getElementById('js-btn-next-week').classList.add('cursor-not-allowed');
                        document.getElementById('js-btn-next-week').classList.add('opacity-50');
                    } else {
                        document.getElementById("js-week-no").value = document.getElementById("js-week-no").value * 1 + 1;
                    }
                });
            }
        }
    }
</script>