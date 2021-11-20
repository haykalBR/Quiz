import Routing from '../../Config/routing';
import { injectable } from 'inversify';
import DataTable from '../../Shared/interfaces/datatable';
import {deleterecord} from "../../Shared/helper/sweetalert2";
import axios from "../../Config/axios";

@injectable()
export default class PermissionsService implements DataTable{

    getAjax(){
        return {
            'url': Routing.generate("admin_permissions"),
            data: function(data,buttons) {

                data.hiddenColumn= [

                ];
                data.customSearch =[

                ]
            },

        }
    }
    getDatableColumnDef():Array<any>{
        let i =0;
        return [

                            {   "targets": i++,'name':'t.id','data':'t_id'},
                            {   "targets": i++,'name':'t.guardName','data':'t_guardName'},
                            {   "targets": i++,'name':'t.name','data':'t_name'},
                        {
                "targets": -1,
                'name':'t.id',
                'data':'t_buttons',
                "render": function ( data, type, full, meta ) {
                    return data;
                }
            }
        ]
    }

    addPermissions():void{
        const headers = {
            'Content-Type': 'application/json',
        }

        axios.post( Routing.generate('api_permissions_add-guard-route_collection'), null, {
            headers: headers
        })
            .then((response) => {
                console.log(response);

            })
            .catch((error) => {
                console.error(error);
            })


    }
}