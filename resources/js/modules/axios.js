import axios from 'axios'

export const axiosModule = {
    baseUrl: "",
    data: {},
    config: {},
    response: null,
    error: null,
    methods: {
        get(handleSuccess, handleError) {
            axios.get(axiosModule.baseUrl, axiosModule.config)
                .then(response => {
                    axiosModule.response = response
                    handleSuccess()
                })
                .catch(error => {
                    axiosModule.error = error
                    handleError()
                });
        },
        post(handleSuccess, handleError) {
            axios.post(axiosModule.baseUrl, axiosModule.data, axiosModule.config)
                .then(response => {
                    axiosModule.response = response
                    handleSuccess()
                })
                .catch(error => {
                    axiosModule.error = error
                    handleError()
                })
        }
    }
}
