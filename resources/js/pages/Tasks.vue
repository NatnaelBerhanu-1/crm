<template>
    <div>
        <div class="page-container">
            <div class="flex flex-row justify-between">
                <p class="title"><font-awesome-icon icon="tasks"/><span class="pl-2">Tasks</span></p>
                <router-link to="add" append>
                    <button class="bg-primary h-8 text-white px-2 rounded text-sm"> <font-awesome-icon icon="plus" size="sm" /> Add Task</button>
                </router-link>
            </div>
            <div class="mt-2  bg-white">
                <table class="w-full">
                    <thead>
                        <tr class=" text-black">
                            <th>Name</th>
                            <th>Phone Number</th>
                            <th>Event Name</th>
                            <th>Place</th>
                            <th>Shot Date</th>
                            <th>Print Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="">
                            <td>Natnael</td>
                            <td>0919298886</td>
                            <td>Photoshot</td>
                            <td>Studio</td>
                            <td>12/03/2020</td>
                            <td>12/03/2020</td>
                        </tr>
                        <tr class="">
                            <td>Natnael</td>
                            <td>0919298886</td>
                            <td>Photoshot</td>
                            <td>Studio</td>
                            <td>12/03/2020</td>
                            <td>12/03/2020</td>
                        </tr>
                        <tr class="">
                            <td>Natnael</td>
                            <td>0919298886</td>
                            <td>Photoshot</td>
                            <td>Studio</td>
                            <td>12/03/2020</td>
                            <td>12/03/2020</td>
                        </tr>
                        <tr class="">
                            <td>Natnael</td>
                            <td>0919298886</td>
                            <td>Photoshot</td>
                            <td>Studio</td>
                            <td>12/03/2020</td>
                            <td>12/03/2020</td>
                        </tr>
                        <tr class="">
                            <td>Natnael</td>
                            <td>0919298886</td>
                            <td>Photoshot</td>
                            <td>Studio</td>
                            <td>12/03/2020</td>
                            <td>12/03/2020</td>
                        </tr>
                        <tr class="">
                            <td>Natnael</td>
                            <td>0919298886</td>
                            <td>Photoshot</td>
                            <td>Studio</td>
                            <td>12/03/2020</td>
                            <td>12/03/2020</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
<style lang="css" scoped>
    td, th{
        @apply border border-gray-300;
    }
</style>