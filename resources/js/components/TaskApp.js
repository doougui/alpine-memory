export default function taskApp() {
    return {
        tasks: [],
        newTask: '',

        submit() {
            this.tasks.push({ body: this.newTask, completed: false });
            this.newTask = '';
        }
    };
}
