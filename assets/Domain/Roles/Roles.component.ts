import { inject, injectable } from "inversify";
import RolesService from "./Roles.service";
import DatatableFactory from "../../Shared/factory/datatableFactory"
@injectable()
export default class RolesComponent {
    private rolesService: RolesService;
    constructor(
        @inject(RolesService) rolesService:RolesService,
        @inject(DatatableFactory) datatableFactory:DatatableFactory,
    ){
        this.rolesService=rolesService;
        let dataTable = datatableFactory.getDatatable('#roles_table', rolesService)
    }
    deleteRole():void{
        $("#roles_table").on('click', '.delete',this.rolesService.deleteRole);
    }
}