import { ref, inject } from 'vue'
//import { useRouter } from 'vue-router'


export default function useUsers() {
    const users = ref([])
    const user = ref({
        name: ''
    })

    //const router = useRouter()
    const validationErrors = ref({})
    const isLoading = ref(false)
    const swal = inject('$swal')

    const getUsers = async (
        page = 1,
        search_id = '',
        search_title = '',
        search_global = '',
        order_column = 'created_at',
        order_direction = 'desc'
    ) => {
        axios.get('/api/birthdaylanding?page=' + page +
            '&search_id=' + search_id +
            '&search_title=' + search_title +
            '&search_global=' + search_global +
            '&order_column=' + order_column +
            '&order_direction=' + order_direction)
            .then(response => {
                users.value = response.data;
                // if(users.value.data.length == 0){
                // console.log(users.value)
                // }
            })
    }

    const getUser = async (id) => {
        axios.get('/api/birthdaylanding/' + id)
            .then(response => {
                user.value = response.data.data;
            })
    }

    

    return {
        users,
        user,
        getUsers,
        getUser,
        validationErrors,
        isLoading
    }
}
