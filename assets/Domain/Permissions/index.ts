import container from '../../Container';
import PermissionsComponent from "./Permissions.component";
let permissionsComponent:PermissionsComponent;
permissionsComponent=container.resolve<PermissionsComponent>(PermissionsComponent);
permissionsComponent.addPermissions();

