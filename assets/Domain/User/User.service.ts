import Routing from '../../Config/routing';
import { injectable } from 'inversify';
import DataTable from '../../Shared/interfaces/datatable';
import {deleterecord} from "../../Shared/helper/sweetalert2";
import axios from "../../Config/axios";
import randomstring from "randomstring";

@injectable()
export default class UserService implements DataTable{

    getAjax(){
        return {
            'url': Routing.generate("admin_user"),
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
          {   "targets": i++,'name':'t.email','data':'t_email'},
          {   "targets": i++,'name':'t.roles','data':'t_roles'},
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

    /**
     * genrete random password
     */
    randompaasword():void{
        let password = randomstring.generate({
            length: 15,
            charset: 'alphanumeric'
        });
        $('#user_plainPassword_first').val(password);
        $('#user_plainPassword_second').val(password);
    }

}