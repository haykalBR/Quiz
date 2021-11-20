import Routing from '../../Config/routing';
import { injectable } from 'inversify';
import DataTable from '../../Shared/interfaces/datatable';
import {deleterecord} from "../../Shared/helper/sweetalert2";
import axios from "../../Config/axios";

@injectable()
export default class RolesService implements DataTable{

    getAjax(){
        return {
            'url': Routing.generate("admin_roles"),
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

}