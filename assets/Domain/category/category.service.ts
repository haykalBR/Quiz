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
                data.join = [
                    {   "join": "App\\Domain\\Categories\\Entity\\Categories","alias": 'c',"condition": "t.id = c.parent","type":""},
                ];
                data.hiddenColumn= [
                    {   name: 't.public',data: 't_public'},
                    {   name: 'c.parent',data: 'c_parent'},
                ];
                data.customSearch =[
                    {'name':'t.public','value':$('#categories_search_search_public').val(),'type':'boolean'},
                    {'name':'c.parent','value':$('#categories_search_parent').val(),'type':'integer'},
                ]
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
        deleterecord(id,"api_categories_delete_item");
    }
    changeState(event:JQuery.ClickEvent):void{
        const  state:boolean =$(this).hasClass( "active" );
        const  id :string = $(this).attr('data-id');
        axios({
            method: 'put',
            url: Routing.generate('api_categories_change-state_item',{id:id}),
            data: {state: !state}
        }).then(async (response) => {
        }, (error) => {
            console.error(error)
        });
    }
}