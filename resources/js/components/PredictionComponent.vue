<template>
    <table class="table-auto" style="width: 280px;">
        <thead>
            <tr>
                <th colspan="3" class="text-center">Prediction</th>
            </tr>
            <tr>
                <th class="text-center border px-4 py-2 bg-gray-100" colspan="3" v-if="weekNo === '-'">League is finished</th>
            </tr>
            <tr>
                <td class="text-center border px-4 py-2 bg-gray-100" colspan="3" v-if="data.length && weekNo !== '-'">{{ weekNo }}th Week Prediction</td>
            </tr>
            <tr>
                <th class="text-center border px-4 py-2 bg-gray-100" colspan="3" v-if="!data.length && weekNo !== '-'">League is not started</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(item, index) in data">
                <td class="border px-2 py-2 text-right">{{ item.home }}</td>
                <td class="border px-2 py-2 text-center">{{ item.score }}</td>
                <td class="border px-2 py-2 text-left">{{ item.away }}</td>
            </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        name: 'prediction-component',
        props: ['data', 'weekNo']
    }
</script>