import { inject, injectable } from "inversify";
import GroupeService from "./Groupe.service";
import DatatableFactory from "../../Shared/factory/datatableFactory"
@injectable()
export default class GroupeComponent {
    private groupeService: GroupeService;
    constructor(
        @inject(GroupeService) groupeService:GroupeService,
        @inject(DatatableFactory) datatableFactory:DatatableFactory,
    ){
        this.groupeService=groupeService;
        let dataTable = datatableFactory.getDatatable('#groupe_table', groupeService)
    }
    deleteGroup():void{
        $("#groupe_table").on('click', '.delete',this.groupeService.deleteGroupe);
    }
}