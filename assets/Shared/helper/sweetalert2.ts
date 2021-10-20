import Swal from '../../Config/sweetAlert';
import axios from "../../Config/axios";
import Routing from '../../Config/routing';

export function deleterecord( id:any ,route:string ):void {
    Swal.fire({
        title: `Are you sure  ${id} ? `,
        text: "You won't be able to revert this!",
        confirmButtonText: 'Yes, delete it!',
        preConfirm: () => {
            axios({
                method: 'DELETE',
                url: Routing.generate(route,{id:id}),
            }).then((response) => {
                Swal.fire(response.data);
            }, (error) => {
                Swal.fire(error.data);
            });
        }
    })
}