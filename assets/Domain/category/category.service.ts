import Routing from '../../Config/routing';
import { injectable } from 'inversify';
import DataTable from '../../Shared/interfaces/datatable';
import {deleterecord} from "../../Shared/helper/sweetalert2";
import axios from "../../Config/axios";

@injectable()
export default class CategoryService implements DataTable{

    getAjax(){
        return {
            'url': Routing.generate("admin_category"),
            data: function(data,buttons) {
                data.hiddenColumn= [
                    {   name: 't.public',data: 't_public'}
                ];
            },

        }
    }
    getDatableColumnDef():Array<any>{
        let i =0;
        return [
            {   "targets": i++,'name':'t.id','data':'t_id'},
            {   "targets": i++,'name':'t.name','data':'t_name' },
            {   "targets": i++,'name':'t.path','data':'t_path',
                "render": function ( data, type, full, meta ) {
                    return '<img class="img-datatable" src="../uploads/category/'+data+'">'
                }
            },
            {   "targets": i++,'name':'t.createdAt','data':'t_createdAt' },
            {   "targets": i++,'name':'t.updatedAt','data':'t_updatedAt' },
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
        deleterecord(id,"api_categories_delete_item");
    }
    changeState(event:JQuery.ClickEvent):void{
        let  mainParent = $(this).parent('.switch ');
        const  state:boolean =$(mainParent).find('input.switch-input').is(':checked');
        const  id :string = $(this).attr('data-id');
        axios({
            method: 'put',
            url: Routing.generate('api_categories_change-state_item',{id:id}),
            data: {state: state}
        }).then(async (response) => {
        }, (error) => {
            console.error(error)
        });
    }
}