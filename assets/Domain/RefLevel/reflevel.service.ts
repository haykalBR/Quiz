import Routing from '../../Config/routing';
import { injectable } from 'inversify';
import DataTable from '../../Shared/interfaces/datatable';
@injectable()
export default class ReflevelService implements DataTable{
    getAjax(){
        return {
            'url': Routing.generate("ref_level"),
            data: function(data) {

            },
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
                'data':'t_id',
                "render": function ( data, type, full, meta ) {
                    let ch="";
                    return ch;
                }
            }
        ]
    }

}