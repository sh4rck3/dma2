import { ref, inject } from 'vue'


export default function usePaycheck() {
    const paychecks = ref([])
    const paycheck = ref({
        name: ''
    })

    //const router = useRouter()
    const validationErrors = ref({})
    const isLoading = ref(false)
    const swal = inject('$swal')

    const getPaychecks = async (
        page = 1,
        search_global = ''
    ) => {
        
        axios.get('/api/paycheckadm?page=' + page +
            '&search_global=' + search_global)
            .then(response => {
                paychecks.value = response.data;
            })
    }

    const getPaycheck = async (id) => {
        axios.get('/api/paycheckadm/' + id)
            .then(response => {
                paycheck.value = response.data.data;
            })
    }

    return {
        paychecks,
        paycheck,
        getPaychecks,
        getPaycheck,
        validationErrors,
        isLoading
    }
}
