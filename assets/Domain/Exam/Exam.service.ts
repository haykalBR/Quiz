import Routing from '../../Config/routing';
import { injectable } from 'inversify';
import DataTable from '../../Shared/interfaces/datatable';
import {deleterecord} from "../../Shared/helper/sweetalert2";
import axios from "../../Config/axios";

@injectable()
export default class ExamService implements DataTable{

    getAjax(){
        return {
            'url': Routing.generate("admin_exam"),
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
                            {   "targets": i++,'name':'t.title','data':'t_title'},
                            {   "targets": i++,'name':'t.duration','data':'t_duration'},
                            {   "targets": i++,'name':'t.passingPercentage','data':'t_passingPercentage'},
                            {   "targets": i++,'name':'t.nbQuestions','data':'t_nbQuestions'},
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