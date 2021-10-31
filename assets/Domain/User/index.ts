import container from '../../Container';
import UserComponent from "./User.component";
let userComponent:UserComponent;
userComponent=container.resolve<UserComponent>(UserComponent);

