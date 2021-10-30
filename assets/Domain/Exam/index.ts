import container from '../../Container';
import ExamComponent from "./Exam.component";
let examComponent:ExamComponent;
examComponent=container.resolve<ExamComponent>(ExamComponent);

