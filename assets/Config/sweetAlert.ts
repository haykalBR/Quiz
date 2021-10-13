import Swal from 'sweetalert2'
Swal.mixin({
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    showLoaderOnConfirm: true,
    allowOutsideClick: () => !Swal.isLoading()
})
export default Swal;