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
        search_global = ''
    ) => {
        
        axios.get('/api/users?page=' + page +
            '&search_global=' + search_global)
            .then(response => {
                users.value = response.data;
            })
    }

    const getUser = async (id) => {
        axios.get('/api/users/' + id)
            .then(response => {
                user.value = response.data.data;
            })
    }

    const storeUser = async (user) => {
        if (isLoading.value) return;

        isLoading.value = true
        validationErrors.value = {}

        let serializedPost = new FormData()
        for (let item in user) {
            if (user.hasOwnProperty(item)) {
                serializedPost.append(item, user[item])
            }
        }

        axios.post('/api/users', serializedPost)
            .then(response => {
                //router.push({name: 'users.index'})
                swal({
                    icon: 'success',
                    title: 'User saved successfully'
                })
            })
            .catch(error => {
                if (error.response?.data) {
                    validationErrors.value = error.response.data.errors
                }
            })
            .finally(() => isLoading.value = false)
    }

    const updateUser = async (user) => {
        if (isLoading.value) return;

        isLoading.value = true
        validationErrors.value = {}

        axios.put('/api/users/' + user.id, user)
            .then(response => {
                //router.push({name: 'users.index'})
                swal({
                    icon: 'success',
                    title: 'User updated successfully'
                })
            })
            .catch(error => {
                if (error.response?.data) {
                    validationErrors.value = error.response.data.errors
                }
            })
            .finally(() => isLoading.value = false)
    }

    const deleteUser = async (id) => {
        swal({
            title: 'Tem certeza?',
            text: 'Você não poderá reverter isso!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sim, deletar!',
            confirmButtonColor: '#ef4444',
            timer: 20000,
            timerProgressBar: true,
            reverseButtons: true
        })
            .then(result => {
                if (result.isConfirmed) {
                    axios.delete('/api/users/destroy/' + id)
                        .then(response => {
                            getUsers()
                            //router.push({name: 'users.index'})
                            swal({
                                icon: 'success',
                                title: 'Usuario deletado com sucesso'
                            })
                        })
                        .catch(error => {
                            swal({
                                icon: 'error',
                                title: 'Erro ao deletar usuario'
                            })
                        })
                }
            })
    }

    return {
        users,
        user,
        getUsers,
        getUser,
        storeUser,
        updateUser,
        deleteUser,
        validationErrors,
        isLoading
    }
}
