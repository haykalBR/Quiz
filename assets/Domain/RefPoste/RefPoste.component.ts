import { inject, injectable } from "inversify";
import RefPosteService from "./RefPoste.service";
import DatatableFactory from "../../Shared/factory/datatableFactory"
@injectable()
export default class RefPosteComponent {
    private refposteService: RefPosteService;
    constructor(
        @inject(RefPosteService) refposteService:RefPosteService,
        @inject(DatatableFactory) datatableFactory:DatatableFactory,
    ){
        this.refposteService=refposteService;
        let dataTable = datatableFactory.getDatatable('#ref_poste_table', refposteService)
    }
    deleteLevel():void{
        $("#ref_poste_table").on('click', '.delete',this.refposteService.deleteLevel);
    }
    changeStateLevel():void{
        $("#ref_poste_table").on('click', '.switch-input',this.refposteService.changeState);
    }
}