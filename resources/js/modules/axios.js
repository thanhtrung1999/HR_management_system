export const axiosModule = {
    baseUrl: "",
    data: {},
    config: {},
    response: null,
    error: null,
    methods: {
        get(handleSuccess, handleError) {
            this.axios.get(this.baseUrl, this.config)
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
            this.axios.post(this.baseUrl, this.data, this.config)
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
