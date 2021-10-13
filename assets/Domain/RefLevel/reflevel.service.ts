import Routing from '../../Config/routing';
import { injectable } from 'inversify';
import DataTable from '../../Shared/interfaces/datatable';
import {deleterecord} from "../../Shared/helper/sweetalert2";
import axios from "../../Config/axios";

@injectable()
export default class ReflevelService implements DataTable{
    getAjax(){
        return {
            'url': Routing.generate("admin_levels"),
            data: function(data,buttons) {},
        }
    }
    getDatableColumnDef():Array<any>{
        let i =0;
        return [
            {   "targets": i++,'name':'t.id','data':'t_id'},
            {   "targets": i++,'name':'t.name','data':'t_name' },
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
    deleteLevel(event:JQuery.ClickEvent):void{
        event.preventDefault();
        const id = $(this).attr('data-id');
        deleterecord(id,"api_ref_levels_delete_item");
    }
    changeState(event:JQuery.ClickEvent):void{
        let  mainParent = $(this).parent('.switch ');
        const  state:boolean =$(mainParent).find('input.switch-input').is(':checked');
        const  id :string = $(this).attr('data-id');
        axios({
            method: 'put',
            url: Routing.generate('api_ref_levels_change-state_collection',{id:id}),
            data: {state: state}
        }).then(async (response) => {
            console.log(response)
        }, (error) => {
            console.error(error)
        });
    }
}