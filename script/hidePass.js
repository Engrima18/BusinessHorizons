let app = Vue.createApp({
    data(){
        return {
            showPassword: false,
            password: null,
            password2: null,
            passwordv: null
        };
    },
    computed: {
        buttonLabel() {
            return (this.showPassword) ? "Hide" : "Show";
        }
      },
    methods: {
        toggleShow() {
            this.showPassword = !this.showPassword;
        },
        
    }    
    
})

app.mount('#app');