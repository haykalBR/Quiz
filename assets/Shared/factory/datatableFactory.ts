import Datatable from "../interfaces/datatable";
import datatableConfig from "../../Config/datatable";
import { injectable } from "inversify";
import "reflect-metadata";
@injectable()
export default class DatatableFactory{
    private service:Datatable;
    constructor(){
    }
    getDatatable(selector:string,service:Datatable){

        this.service= service;
        return $(selector).DataTable(this.setDatatableConfig());
    }
    private setDatatableConfig(){
        datatableConfig.columnDefs = this.service.getDatableColumnDef();
        datatableConfig.ajax = this.service.getAjax();
        return datatableConfig;
    }
}