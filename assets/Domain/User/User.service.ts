import Routing from '../../Config/routing';
import { injectable } from 'inversify';
import DataTable from '../../Shared/interfaces/datatable';
import {deleterecord} from "../../Shared/helper/sweetalert2";
import axios from "../../Config/axios";
import randomstring from "randomstring";
import {AxiosResponse} from "axios";
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
    async reloadPermissions(){
      let roles=$('#user_role').select2('data').map(o => parseInt(o['id']))
      const data = await axios.post(Routing.generate('api_users_permission-from-roles_collection'),{ roles: roles})
      .then(res=> res.data)
      .then(response => { return Object.values(response)})
      .catch(error => console.log(error))
         return data;
    }
    addPermissionToSelect(routes: AxiosResponse<any> | void):void{
        this.addGrantPermissionToSelect(routes[0])
        this.addRevokePermissionToSelect(routes[1])
    }
    private addGrantPermissionToSelect(routes:Array<any>):void{
        var grantPermission = $("#user_grantPermission");
        grantPermission.html('');
        routes.forEach(function(route) {
            grantPermission.append('<option value="' + route.id + '">' + route.guardName+ '</option>');
        });
    }
    private addRevokePermissionToSelect(routes:Array<any>):void{
        var revokePermission = $("#user_revokePermission");
        revokePermission.html('');
        routes.forEach(function(route) {
            revokePermission.append('<option value="' + route.id + '">' + route.guardName+ '</option>');
        });
    }
    rolesStrategy(){
        $('#show-roles-strategy').show();
        $('#show-groupe-strategy').hide();
        $('#show-user-strategy').hide();
        $('.select2 ').val('').trigger("change");
    }
    groupestrategy(){
        $('#show-roles-strategy').hide();
        $('#show-groupe-strategy').show();
        $('#show-user-strategy').hide();
        $('.select2 ').val('').trigger("change");
    }
    userstrategy(){
        $('#show-roles-strategy').hide();
        $('#show-groupe-strategy').hide();
        $('#show-user-strategy').show();
        $('.select2 ').val('').trigger("change");
    }

    deleteUser(event:JQuery.ClickEvent):void{
        event.preventDefault();
        const id = $(this).attr('data-id');
        deleterecord(id,"api_users_delete_item");
    }
}