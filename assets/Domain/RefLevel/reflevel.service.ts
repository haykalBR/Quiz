import Routing from '../../Config/routing';
import { injectable } from 'inversify';
import DataTable from '../../Shared/interfaces/datatable';
@injectable()
export default class ReflevelService implements DataTable{
    getAjax(){
        console.warn(55)
        return {
            'url': Routing.generate("ref_level"),
            data: function(data,buttons) {

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
                'data':'t_buttons',
                "render": function ( data, type, full, meta ) {
                    return data;
                }
            }
        ]
    }

}