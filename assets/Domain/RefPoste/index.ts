import container from '../../Container';
import RefPosteComponent from "./RefPoste.component";
let refposteComponent:RefPosteComponent;
refposteComponent=container.resolve<RefPosteComponent>(RefPosteComponent);
refposteComponent.deleteLevel();
refposteComponent.changeStateLevel();