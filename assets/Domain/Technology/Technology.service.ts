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
                            {   "targets": i++,'name':'t.uploadDir','data':'t_uploadDir'},
                            {   "targets": i++,'name':'t.namer','data':'t_namer'},
                            {   "targets": i++,'name':'t.allowedTypes','data':'t_allowedTypes'},
                            {   "targets": i++,'name':'t.file','data':'t_file'},
                            {   "targets": i++,'name':'t.path','data':'t_path'},
                            {   "targets": i++,'name':'t.rootDir','data':'t_rootDir'},
                            {   "targets": i++,'name':'t.webSubDir','data':'t_webSubDir'},
                            {   "targets": i++,'name':'t.webDir','data':'t_webDir'},
                            {   "targets": i++,'name':'t.relativePath','data':'t_relativePath'},
                            {   "targets": i++,'name':'t.relativeUrl','data':'t_relativeUrl'},
                            {   "targets": i++,'name':'t.absolutePath','data':'t_absolutePath'},
                            {   "targets": i++,'name':'t.absoluteUploadDir','data':'t_absoluteUploadDir'},
                            {   "targets": i++,'name':'t.filters','data':'t_filters'},
                            {   "targets": i++,'name':'t.createdAt','data':'t_createdAt'},
                            {   "targets": i++,'name':'t.updatedAt','data':'t_updatedAt'},
                            {   "targets": i++,'name':'t.deletedAt','data':'t_deletedAt'},
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