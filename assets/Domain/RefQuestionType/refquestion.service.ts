import Routing from '../../Config/routing';
import { injectable } from 'inversify';
import DataTable from '../../Shared/interfaces/datatable';
import {deleterecord} from "../../Shared/helper/sweetalert2";
import axios from "../../Config/axios";

@injectable()
export default class RefquestionService implements DataTable{
    getAjax(){
        return {
            'url': Routing.generate("admin_ref_question"),
            data: function(data,buttons) {
                data.hiddenColumn= [
                    {   name: 't.enabled',data: 't_enabled'}
                ];
            },

        }
    }
    getDatableColumnDef():Array<any>{

        let i =0;
        return [
            {   "targets": i++,'name':'t.id','data':'t_id'},
            {   "targets": i++,'name':'t.name','data':'t_name' },
            {   "targets": i++,'name':'t.createdAt','data':'t_createdAt',
                "render": function ( data, type, full, meta ) {
                    return '<a href="#" class=" text-center badge badge-success">'+data+'</a>'
                }
            },
            {   "targets": i++,'name':'t.updatedAt','data':'t_updatedAt',
                "render": function ( data, type, full, meta ) {
                    return '<a href="#" class="badge badge-success">'+data+'</a>'
                }
            },
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
        const  state:boolean =$(this).hasClass( "active" );
        const  id :string = $(this).attr('data-id');
        axios({
            method: 'put',
            url: Routing.generate('api_ref_levels_change-state_item',{id:id}),
            data: {state: !state}
        }).then(async (response) => {
        }, (error) => {
            console.error(error)
        });
    }
}