import Routing from '../../Config/routing';
import { injectable } from 'inversify';
import DataTable from '../../Shared/interfaces/datatable';
import {deleterecord} from "../../Shared/helper/sweetalert2";
import axios from "../../Config/axios";

@injectable()
export default class RefPosteService implements DataTable{

    getAjax(){
        return {
            'url': Routing.generate("admin_refposte"),
            data: function(data,buttons) {
                data.hiddenColumn= [
                    {   name: 't.enabled',data: 't_enabled'}
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
    deleteLevel(event:JQuery.ClickEvent):void{
        event.preventDefault();
        const id = $(this).attr('data-id');
        deleterecord(id,"api_ref_postes_delete_item");
    }
    changeState(event:JQuery.ClickEvent):void{
        const  state:boolean =$(this).hasClass( "active" );
        const  id :string = $(this).attr('data-id');
        axios({
            method: 'put',
            url: Routing.generate('api_ref_postes_change-state_item',{id:id}),
            data: {state: !state}
        }).then(async (response) => {
        }, (error) => {
            console.error(error)
        });
    }

}