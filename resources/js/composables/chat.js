import { ref, inject } from 'vue'
//import { useRouter } from 'vue-router'


export default function useContacts() {
    const contacts = ref([])
    const contact = ref({
        name: ''
    })
    const messages = ref([])

    //const router = useRouter()
    const validationErrors = ref({})
    const isLoading = ref(false)
    const swal = inject('$swal')

    const getContacts = async () => {
        
        axios.get('/api/contacts/')
            .then(response => {
                contacts.value = response.data
            })
    }

    const loadMessages = async (id) => {
        console.log('loadMessages')
        console.log(id)
        axios.get(`/api/messages/${id}`)
            .then(response => {
                messages.value = response.data
            })
    }     

    return {
        contacts,
        contact,
        messages,
        getContacts,
        loadMessages,
        validationErrors,
        isLoading
    }
}
