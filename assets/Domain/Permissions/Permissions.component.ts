import { inject, injectable } from "inversify";
import PermissionsService from "./Permissions.service";
import DatatableFactory from "../../Shared/factory/datatableFactory"
@injectable()
export default class PermissionsComponent {
    private permissionsService: PermissionsService;
    constructor(
        @inject(PermissionsService) permissionsService:PermissionsService,
        @inject(DatatableFactory) datatableFactory:DatatableFactory,
    ){
        this.permissionsService=permissionsService;
        let dataTable = datatableFactory.getDatatable('#permissions_table', permissionsService)
    }

}