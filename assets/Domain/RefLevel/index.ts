import container from '../../Container';
import ReflevelComponent from "./reflevel.component";
let reflevels:ReflevelComponent;
reflevels=container.resolve<ReflevelComponent>(ReflevelComponent);
reflevels.deleteLevel();
