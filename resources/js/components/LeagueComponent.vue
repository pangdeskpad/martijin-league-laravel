<template>
    <table class="table-auto">
        <thead>
            <tr>
                <th colspan="7" class="text-center">League Table</th>
            </tr>
            <tr>
                <th class="border px-4 py-2 bg-gray-100">Teams</th>
                <th class="border px-4 py-2 bg-gray-100">PTS</th>
                <th class="border px-4 py-2 bg-gray-100">P</th>
                <th class="border px-4 py-2 bg-gray-100">W</th>
                <th class="border px-4 py-2 bg-gray-100">D</th>
                <th class="border px-4 py-2 bg-gray-100">L</th>
                <th class="border px-4 py-2 bg-gray-100">GD</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(item, index) in data">
                <td class="border px-2 py-2">{{ item.team }}</td>
                <td class="border px-4 py-2">{{ item.pts }}</td>
                <td class="border px-4 py-2">{{ item.p }}</td>
                <td class="border px-4 py-2">{{ item.w }}</td>
                <td class="border px-4 py-2">{{ item.d }}</td>
                <td class="border px-4 py-2">{{ item.l }}</td>
                <td class="border px-4 py-2">{{ item.gd }}</td>
            </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        name: 'league-component',
        props: ['data']
    }
</script>