import { ref, inject } from 'vue'


export default function useSendsms() {
    const smss = ref([])
    const sms = ref({
        phone: ''
    })

    //const router = useRouter()
    const validationErrors = ref({})
    const isLoading = ref(false)
    const swal = inject('$swal')

    const getSmss = async (
        page = 1,
        search_global = ''
    ) => {
        
        axios.get('/api/responsesms?page=' + page +
            '&search_global=' + search_global)
            .then(response => {
                smss.value = response.data;
            })
    }

    const getSms = async (id) => {
        axios.get('/api/responsesms/' + id)
            .then(response => {
                user.value = response.data.data;
            })
    }

    return {
        smss,
        sms,
        getSmss,
        getSms,
        validationErrors,
        isLoading
    }
}
