import { ref, inject } from 'vue'


export default function useLegal() {
    const legals = ref([])
    const legal = ref({
        title: ''
    })

    //const router = useRouter()
    const validationErrors = ref({})
    const isLoading = ref(false)
    const swal = inject('$swal')

    const getLegals = async (
        page = 1,
        search_global = ''
    ) => {
        
        axios.get('/api/legal?page=' + page +
            '&search_global=' + search_global)
            .then(response => {
                legals.value = response.data;
            })
    }


    return {
        legals,
        legal,
        getLegals,
        validationErrors,
        isLoading
    }
}
