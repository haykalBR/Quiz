import { inject, injectable } from "inversify";
import RefPosteService from "./refposte.service";
import DatatableFactory from "../../Shared/factory/datatableFactory"
@injectable()
export default class RefPosteComponent {
    private refposteService: RefPosteService;
    constructor(
        @inject(RefPosteService) refposteService:RefPosteService,
        @inject(DatatableFactory) datatableFactory:DatatableFactory,
    ){
        this.refposteService=refposteService;
        let dataTable = datatableFactory.getDatatable('#refposte_table', refposteService)
    }

}