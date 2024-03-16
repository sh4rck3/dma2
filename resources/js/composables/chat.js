import axios from 'axios'
import { ref, inject } from 'vue'
//import { useRouter } from 'vue-router'


export default function useContacts() {
    const contacts = ref([])
    const contact = ref({
        name: ''
    })
    const messages = ref([])
    const userActive = ref(null)
    const message = ref('')

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
        //console.log('loadMessages')
        //console.log(id)
        axios.get(`/api/contacts/${id}`)
            .then(response => {
                userActive.value = response.data.ticketUser
                //console.log(userActive)
            })

        axios.get(`/api/messages/${id}`)
            .then(response => {
                messages.value = response.data
            })
    }
    
    const sendMessage = async (message) => {
        //isLoading.value = true
        console.log('sendMessage')
        //console.log(id)
        console.log(message)
        // axios.post(`/api/messages/${id}`, {
        //     message: message
        // })
        // .then(response => {
        //     messages.value.push(response.data)
        //     isLoading.value = false
        // })
        // .catch(error => {
        //     if (error.response.status === 422) {
        //         validationErrors.value = error.response.data.errors
        //     } else {
        //         swal({
        //             title: 'Error',
        //             text: 'Something went wrong!',
        //             icon: 'error'
        //         })
        //     }
        //     isLoading.value = false
        // })
    
    }

    return {
        contacts,
        contact,
        userActive,
        messages,
        getContacts,
        loadMessages,
        sendMessage,
        validationErrors,
        isLoading
    }
}
