import swal from 'sweetalert';
window.Vue = require('vue');
/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token   = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('token not found');
}
// Vue.component('vue-prism-editor', VuePrismEditor)

// let settingType = {
//     init: "{{$setting->type}}",
//     listener(event) { },
//     set type(value) {
//         this.init = value
//         this.listener(value)
//     },
//     get type() {
//         return this.init
//     },
//     registerListener(listener) {
//         this.listener = listener
//     }
// }

// function updateSelection(e) {
//     settingType.type = document.getElementById('type').value
// }

// Vue.component('json-editor', {
//     data() {
//         return {
//             code: @json($setting -> value),
//             visible: false,
//             cleanCode: @json($setting -> value)
//     }
// },
//     mounted() {
//         this.code = JSON.stringify(JSON.parse(this.code), null, 4);
//         this.visible = settingType.init == 'JSON'
//         settingType.registerListener((e) => {
//             console.log(e)
//             this.visible = e == 'JSON'
//         })
//     },
//     watch: {
//         code: {
//             deep: true,
//             immediate: true,
//             handler: function (val, oldVal) {
//                 this.cleanCode = JSON.stringify(JSON.parse(val))
//             }
//         },
//     },
//         })

// new Vue({
//     el: '#editor',
// })

// function deleteSetting(_setting) {
//     swal({
//         title: "Are you sure?",
//         text: "Once deleted, you will not be able to recover - " + _setting.key,
//         icon: "warning",
//         buttons: true,
//         dangerMode: true,
//     })
//         .then((willDelete) => {
//             if (willDelete) {
//                 // delete the setting that is now been confirmed
//                 axios.delete('/system/settings/' + _setting.id).then(response => {
//                     if (response.status == 200) {
//                         swal(`Poof! Your Setting\n ${_setting.key} \n has been deleted!`, { icon: "success" });
//                     }
//                 })
//             } else {
//                 swal("Your setting is safe!", { icon: 'info' });
//             }
//         });
// }