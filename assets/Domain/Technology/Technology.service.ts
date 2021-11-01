import Routing from '../../Config/routing';
import { injectable } from 'inversify';
import DataTable from '../../Shared/interfaces/datatable';
import {deleterecord} from "../../Shared/helper/sweetalert2";
import axios from "../../Config/axios";

@injectable()
export default class TechnologyService implements DataTable{

    getAjax(){
        return {
            'url': Routing.generate("admin_technology"),
            data: function(data,buttons) {
                data.join = [
/*
                    {   "join": "App\\Domain\\Categories\\Entity\\Categories","alias": 'c',"condition": "t.categories in c.id","type":""},
*/
                ];
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
            {   "targets": i++,'name':'t.name','data':'t_name'},
            {   "targets": i++,'name':'t.slug','data':'t_slug'},
            {   "targets": i++,'name':'t.createdAt','data':'t_createdAt'},
            {   "targets": i++,'name':'t.updatedAt','data':'t_updatedAt'},
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