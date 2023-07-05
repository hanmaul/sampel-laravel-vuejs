<script setup>
// pake vue composition api
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';
import axios from 'axios';
import { ref, onMounted, watch } from "vue";

import DialogModal from "@/Components/DialogModal.vue";

onMounted(()=>{
    getKonsumen()
})

const daftarKonsumenLoading = ref(false)
const daftarKonsumen = ref({})
const getKonsumen = () => {
    daftarKonsumen.value = {}
    daftarKonsumenLoading.value = true
    axios.get(route("konsumen.data")).then(res=>{
        const data = res.data
        daftarKonsumen.value = data
        daftarKonsumenLoading.value = false
    }).catch(err=>{
        alert(`Gagal mengambil data\n\nError: ${err}`)
    })
}

const current_page = ref(1)
const setPage = (d) => {
    if(d){
        const s = (d.url).split("?page=")
        const p = s[1]
        current_page.value = p
        getKonsumen()
    }
}
const pageClasses = (d) => {
    if (d.active) {
        return 'text-white bg-cyan-600 border-cyan-600 cursor-not-allowed'
    } else if (d.url == null) {
        return 'text-gray-400 cursor-not-allowed'
    } else {
        return 'text-gray-600 hover:bg-gray-100'
    }
}

const formKonsumen = useForm({
    no_kontrak:'',
    nama:'',
    jenis_kelamin:'',
    kota_id:'',
    kecamatan_id:'',
    kelurahan_id:'',
    kode_pos:'',
    alamat:'',
})

const daftarKota = ref(false)
const getKota = () => {
    daftarKota.value = false
    axios.get(route("alamat.kota")).then(res=>{
        const data = res.data
        daftarKota.value = data
    }).catch(err=>{
        alert(`Gagal mengambil data\n\nError: ${err}`)
    })
}

const daftarKecamatan = ref(false)
const getKecamatan = () => {
    daftarKecamatan.value = false
    axios.post(route("alamat.kecamatan"),{
        kota_id: formKonsumen.kota_id,
    }).then(res=>{
        const data = res.data
        daftarKecamatan.value = data
    }).catch(err=>{
        alert(`Gagal mengambil data\n\nError: ${err}`)
    })
}

const daftarKelurahan = ref(false)
const getKelurahan = () => {
    daftarKelurahan.value = false
    axios.post(route("alamat.kelurahan"),{
        kecamatan_id:formKonsumen.kecamatan_id,
    }).then(res=>{
        const data = res.data
        daftarKelurahan.value = data
    }).catch(err=>{
        alert(`Gagal mengambil data\n\nError: ${err}`)
    })
}

watch(()=>formKonsumen.kota_id, ()=>{
    getKecamatan()
})
watch(()=>formKonsumen.kecamatan_id, ()=>{
    getKelurahan()
})

const modalKonsumenOpen = ref(false)
const tambahModalKonsumen = () => {
    modalKonsumenOpen.value = true
    detailKonsumen.value = false
    resetFormKonsumen()
    getKota()
}

const resetFormKonsumen = () => {
    formKonsumen.reset()
    formKonsumen.clearErrors()
    konsumen_id.value = false
}

const detailKonsumen = ref(false)
const modalDetailKonsumen = (d) => {
    konsumen_id.value = false
    detailKonsumen.value = d
    modalKonsumenOpen.value = true
    getKota()
}

const simpanKonsumen = () => {
    formKonsumen.clearErrors()
    formKonsumen.transform(data=>({
        ...data,
        konsumen_id: konsumen_id.value
    })).post(route("konsumen.simpan"),{
        onSuccess:()=>{
            modalKonsumenOpen.value = false
            resetFormKonsumen()
            getKonsumen()
            alert("Berhasil Disimpan")
        },
    })
}

const konsumen_id = ref(false)
const ubahKonsumen = () => {
    const data = detailKonsumen.value
    konsumen_id.value = data.id

    formKonsumen.no_kontrak = data.no_kontrak
    formKonsumen.nama = data.nama
    formKonsumen.jenis_kelamin = data.jenis_kelamin
    formKonsumen.kota_id = data.kota_id
    formKonsumen.kecamatan_id = data.kecamatan_id
    formKonsumen.kelurahan_id = data.kelurahan_id
    formKonsumen.kode_pos = data.kode_pos
    formKonsumen.alamat = data.alamat
}

const hapusKonsumen = () => {
    if(confirm("Yakin ingin dihapus")){
        const konsumen_id = detailKonsumen.value.id
        axios.delete(route("konsumen.hapus",{konsumen_id})).then(()=>{
            alert(`Berhasil dihapus`)
            modalKonsumenOpen.value = false
            resetFormKonsumen()
            getKonsumen()
        }).catch(err => {
            alert(`Gagal menghapus data\n\nError: ${err}`)
        })
    }
}

</script>

<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex justify-end mb-1">
                            <button @click="tambahModalKonsumen()" type="button" class="rounded-md px-2 py-1 text-white bg-indigo-600 hover:bg-indigo-700">
                                Tambah
                            </button>
                        </div>
                        <table class="w-full">
                            <thead class="bg-gray-600 text-white">
                                <tr>
                                    <td class="px-2 py-1 font-semibold w-10">No.</td>
                                    <td class="px-2 py-1 font-semibold">No. Kontrak</td>
                                    <td class="px-2 py-1 font-semibold">Nama</td>
                                    <td class="px-2 py-1 font-semibold">Jenis Kelamin</td>
                                    <td class="px-2 py-1 font-semibold"></td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(data,index) in daftarKonsumen.data" :key="index" class="even:bg-gray-50 hover:bg-gray-100">
                                    <td class="px-2 py-1">{{ index+1 }}</td>
                                    <td class="px-2 py-1">{{ data.no_kontrak }}</td>
                                    <td class="px-2 py-1">{{ data.nama }}</td>
                                    <td class="px-2 py-1">{{ data.jenis_kelamin }}</td>
                                    <td class="px-2 py-1 text-right">
                                        <button @click="modalDetailKonsumen(data)" type="button" class="px-2 py-1 rounded-md bg-gray-600 hover:bg-gray-700 text-white">
                                            Detail
                                        </button>
                                    </td>
                                </tr>
                                <tr v-if="daftarKonsumenLoading">
                                    <td colspan="5" class="px-2 py-1 text-center font-bold">
                                        :: Loading ::
                                    </td>
                                </tr>
                                <tr v-else-if="daftarKonsumen && (!daftarKonsumen.data || (daftarKonsumen.data && daftarKonsumen.data.length<=0))">
                                    <td colspan="5" class="px-2 py-1 text-center font-bold">
                                        :: Tidak Ada Data ::
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div v-if="daftarKonsumen && daftarKonsumen.links" class="flex p-2 bg-white">
                            <button @click="setPage(d)" type="button" v-for="(d, i) in daftarKonsumen.links" :key="i" v-html="d.label" class="px-2 py-1 border-y border-l last:border-r first:rounded-l-md last:rounded-r-md font-semibold" :class="pageClasses(d)"></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>

    <DialogModal :show="modalKonsumenOpen" @close="modalKonsumenOpen=false">
        <template #title>
            Detail Konsumen
        </template>
        <template #content>
            <div class="text-gray-600 space-y-1">
                <div class="flex">
                    <div class="flex-initial w-36 font-semibold">No. Kontrak</div>
                    <div class="flex-1">
                        <template v-if="detailKonsumen && !konsumen_id">
                            {{ detailKonsumen.no_kontrak }}
                        </template>
                        <template v-else>
                            <input v-model="formKonsumen.no_kontrak" type="text" class="px-2 py-1 rounded-md border-gray-300" placeholder="Ketik Disini">
                            <div v-if="formKonsumen.errors" class="text-xs text-red-600">{{ formKonsumen.errors.no_kontrak }}</div>
                        </template>
                    </div>
                </div>
                <div class="flex">
                    <div class="flex-initial w-36 font-semibold">Nama</div>
                    <div class="flex-1">
                        <template v-if="detailKonsumen && !konsumen_id">
                            {{ detailKonsumen.nama }}
                        </template>
                        <template v-else>
                            <input v-model="formKonsumen.nama" type="text" class="px-2 py-1 rounded-md border-gray-300" placeholder="Ketik Disini">
                            <div v-if="formKonsumen.errors" class="text-xs text-red-600">{{ formKonsumen.errors.nama }}</div>
                        </template>
                    </div>
                </div>
                <div class="flex">
                    <div class="flex-initial w-36 font-semibold">Jenis Kelamin</div>
                    <div class="flex-1">
                        <template v-if="detailKonsumen && !konsumen_id">
                            {{ detailKonsumen.jenis_kelamin }}
                        </template>
                        <template v-else>
                            <select v-model="formKonsumen.jenis_kelamin" class="pl-2 py-1 rounded-md border-gray-300">
                                <option value="" disabled selected>:: Pilih Satu ::</option>
                                <option value="Laki-Laki">Laki-Laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                            <div v-if="formKonsumen.errors" class="text-xs text-red-600">{{ formKonsumen.errors.jenis_kelamin }}</div>
                        </template>
                    </div>
                </div>
                <div class="flex">
                    <div class="flex-initial w-36 font-semibold">Kota</div>
                    <div class="flex-1">
                        <template v-if="detailKonsumen && !konsumen_id">
                            {{ detailKonsumen.kota ? detailKonsumen.kota.nama : '-' }}
                        </template>
                        <template v-else>
                            <select v-model="formKonsumen.kota_id" class="pl-2 py-1 rounded-md border-gray-300">
                                <option value="" v-if="!daftarKota" disabled selected> :: Loading :: </option>
                                <option value="" v-else disabled selected>:: Pilih Satu ::</option>
                                <option :value="data.id" v-for="(data,index) in daftarKota" :key="index"> {{ data.nama }} </option>
                            </select>
                            <div v-if="formKonsumen.errors" class="text-xs text-red-600">{{ formKonsumen.errors.kota_id }}</div>
                        </template>
                    </div>
                </div>
                <div class="flex">
                    <div class="flex-initial w-36 font-semibold">Kecamatan</div>
                    <div class="flex-1">
                        <template v-if="detailKonsumen && !konsumen_id">
                            {{ detailKonsumen.kecamatan ? detailKonsumen.kecamatan.nama : '-' }}
                        </template>
                        <template v-else>
                            <select v-model="formKonsumen.kecamatan_id" :class="{'cursor-not-allowed bg-gray-200':!formKonsumen.kota_id}" :disabled="!formKonsumen.kota_id" class="pl-2 py-1 rounded-md border-gray-300">
                                <option value="" v-if="!daftarKecamatan && formKonsumen.kota_id" disabled selected> :: Loading :: </option>
                                <option value="" v-else disabled selected>:: Pilih Satu ::</option>
                                <option :value="data.id" v-for="(data,index) in daftarKecamatan" :key="index"> {{ data.nama }} </option>
                            </select>
                            <div v-if="formKonsumen.errors" class="text-xs text-red-600">{{ formKonsumen.errors.kecamatan_id }}</div>
                        </template>
                    </div>
                </div>
                <div class="flex">
                    <div class="flex-initial w-36 font-semibold">Kelurahan</div>
                    <div class="flex-1">
                        <template v-if="detailKonsumen && !konsumen_id">
                            {{ detailKonsumen.kelurahan ? detailKonsumen.kelurahan.nama : '-' }}
                        </template>
                        <template v-else>
                            <select v-model="formKonsumen.kelurahan_id" :class="{'cursor-not-allowed bg-gray-200':!formKonsumen.kecamatan_id}" :disabled="!formKonsumen.kecamatan_id" class="pl-2 py-1 rounded-md border-gray-300">
                                <option value="" v-if="!daftarKelurahan && formKonsumen.kecamatan_id" disabled selected> :: Loading :: </option>
                                <option value="" v-else disabled selected>:: Pilih Satu ::</option>
                                <option :value="data.id" v-for="(data,index) in daftarKelurahan" :key="index"> {{ data.nama }} </option>
                            </select>
                            <div v-if="formKonsumen.errors" class="text-xs text-red-600">{{ formKonsumen.errors.kelurahan_id }}</div>
                        </template>
                    </div>
                </div>
                <div class="flex">
                    <div class="flex-initial w-36 font-semibold">Kode POS</div>
                    <div class="flex-1">
                        <template v-if="detailKonsumen && !konsumen_id">
                            {{ detailKonsumen.kode_pos }}
                        </template>
                        <template v-else>
                            <input v-model="formKonsumen.kode_pos" type="text" class="px-2 py-1 rounded-md border-gray-300" placeholder="Ketik Disini">
                            <div v-if="formKonsumen.errors" class="text-xs text-red-600">{{ formKonsumen.errors.kode_pos }}</div>
                        </template>
                    </div>
                </div>
                <div class="flex">
                    <div class="flex-initial w-36 font-semibold">Alamat</div>
                    <div class="flex-1">
                        <template v-if="detailKonsumen && !konsumen_id">
                            {{ detailKonsumen.alamat }}
                        </template>
                        <template v-else>
                            <textarea v-model="formKonsumen.alamat" class="px-2 py-1 rounded-md border-gray-300" placeholder="Ketik Disini"></textarea>
                            <div v-if="formKonsumen.errors" class="text-xs text-red-600">{{ formKonsumen.errors.alamat }}</div>
                        </template>
                    </div>
                </div>
            </div>
        </template>
        <template #footer>
            <div class="flex justify-end space-x-2">
                <template v-if="detailKonsumen && !konsumen_id">
                    <button @click="ubahKonsumen()" type="button" class="rounded-md px-2 py-1 bg-yellow-600 hover:bg-yellow-700 text-white">
                        Ubah
                    </button>
                    <button @click="hapusKonsumen()" type="button" class="rounded-md px-2 py-1 bg-red-600 hover:bg-red-700 text-white">
                        Hapus
                    </button>
                </template>
                <template v-else>
                    <button @click="simpanKonsumen()" type="button" :disabled="formKonsumen.processing" class="rounded-md px-2 py-1 bg-green-600 hover:bg-green-700 text-white">
                        {{ formKonsumen.processing ? 'Loading' : 'Simpan' }}
                    </button>
                </template>
            </div>
        </template>
    </DialogModal>
</template>
