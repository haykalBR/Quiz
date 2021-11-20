import { inject, injectable } from "inversify";
import UserService from "./User.service";
import DatatableFactory from "../../Shared/factory/datatableFactory"
@injectable()
export default class UserComponent {
    private userService: UserService;
    constructor(
        @inject(UserService) userService:UserService,
        @inject(DatatableFactory) datatableFactory:DatatableFactory,
    ){
        this.userService=userService;
        let dataTable = datatableFactory.getDatatable('#user_table', userService)
    }

    randompaasword(){
        $('#user_random_password').on('click',this.userService.randompaasword);
    }
     reloadPermissions(){
        $('#user_role').on('change',async () => {
          const data :any  = await this.userService.reloadPermissions()
          this.userService.addPermissionToSelect(data);
        }
        );
    }
}