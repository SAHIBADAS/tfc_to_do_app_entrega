function $(id) {
    return document.getElementById(id);
}

export const DomElements = {

    //Otros
    proyectContainer: $("pro1"),
    collabContainer: $("pro3"),
    dashboard: $("dashboard"),
    newbutton: $("new"),
    addcollab: $("addcollab"),
    proyectos: $("proyectos"),
    colaboradores: $("colaboradores"),
    editUserButton: $("usermenu-button"),
    cancelEditUser: $("canceledituser"),
    formchat: $("formchat"),
    chatcontent: $("chatcontent"),
    chatdiv: $("chatdiv"),
    editUser: $("edit-user"),
    heroBtn: $("hero-butt"),
    addCollabImg: $("addcollab-img"),
    newProImg: $("newpro-img"),
    userButt: $("usermenu-button-img"),

    newProForm: $("new-pro"),
    newProName: $("new-pro-name"),
    newProError: $("new-pro-error"),

    newCollabForm: $("new-collab-form"),
    newCollabEmail: $("new-collab-email"),
    newCollabEmailError: $("new-collab-email-error"),

    //Contenedores Drag and Drop
    doing: $("doing"),
    done: $("done"),
    todo: $("todo"),
    sprint: $("sprint"),
    backlog: $("backlog"),
    trash: $("trash"),

    //Modales
    pro1: $("pro1"),
    pro2: $("pro2"),
    newpro: $("newpro"),
    cancelcreate: $("cancelcreate"),
    cancelnewtask: $("cancelnewtask"),
    chat: $("chat"),
    closebutton: $("closeSession"),
    newcollab: $("newcollab"),
    closecollab: $("cancelnewcollab"),
    addcollab: $("addcollab"),
    pro3: $("pro3"),
    newbutton: $("new"),
    addbutton: $("addbutton"),
    newtask: $("newtask"),

    //Formulario Login
    emailLogin: $("email-login"),
    passwordLogin: $("password-login"),

    //Error Formulario Login
    erroremailLog: $("erroremail-log"),
    errorpasswordLog: $("errorpass-log"),

    //Formulario Editar Usuario
    editUserForm: $("form-edit-user"),

    editUserName: $("edit-user-name"),
    editUserLastName: $("edit-user-lastname"),
    editUserFoto: $("edit-user-foto"),

    //Error Formulario Editar Usuario
    errornameUser: $("edit-user-errorname"),
    errorlastnameUser: $("edit-user-errorlastname"),
    errorfotoUser: $("edit-user-errorfoto"),

    //Formulario Editar Tarea
    editTaskForm: $("edit-task-form"),

    titleEdit: $("title-edit"),
    estimationEdit: $("estimation-edit"),
    stateEdit: $("state-edit"),
    priorityEdit: $("priority-edit"),
    descEdit: $("desc-edit"),
    idEdit: $("id-edit"),

    errorTitleEdit: $("errortitle-edit"),
    errorEstimationEdit: $("errorestimation-edit"),
    errorStateEdit: $("errorstate-edit"),
    errorPriorityEdit: $("errorpriority-edit"),
    errorDescEdit: $("errordesc-edit"),
    colorEdit: $("coloredit"),

    deleteTask: $("deletetask"),
    asigEdit: $("asig-edit"),

    //Formulario Registro
    nameReg: $("name-reg"),
    lastnameReg: $("lastname-reg"),
    emailReg: $("email-reg"),
    passwordReg: $("password-reg"),
    confirmPasswordReg: $("confirm-password-reg"),

    errornameReg: $("errorname-reg"),
    errorlastnameReg: $("errorlastname-reg"),
    erroremailReg: $("erroremail-reg"),
    errorpassReg: $("errorpass-reg"),
    errorpass2Reg: $("errorpass2-reg"),

    //Formulario nueva tarea
    newTaskForm: $("new-task-form"),

    titleNew: $("title-new"),
    estimationNew: $("estimation-new"),
    stateNew: $("state-new"),
    priorityNew: $("priority-new"),
    descNew: $("desc-new"),

    errorTitleNew: $("errortitle-new"),
    errorEstimationNew: $("errorestimation-new"),
    errorStateNew: $("errorstate-new"),
    errorPriorityNew: $("errorpriority-new"),
    errorDescNew: $("errordesc-new"),
    asigSelect: $("asig"),

    //Calendar
    monthYear: $("monthYear"),
    calendarGrid: $("calendarGrid"),
    prevMonth: $("prevMonth"),
    nextMonth: $("nextMonth"),

    //Modales
    modalMessage: $("modalMessage"),
    modal: $("confirmationModal"),
    acceptBtn: $("acceptBtn"),
    cancelBtn: $("cancelBtn"),

    modal2: $("errorModal"),
    modalMessageError: $("modalMessageError"),
    acceptBtn2: $("acceptBtn2"),

    changePasswordModalBtn: $("changePasswordModalBtn"),
    modalPassword: $("passModal"),

    successDiv: $("successDiv"),

    //Cambiar contraseña    
    newpass: $("newpass"),
    newpass2: $("newpass-conf"),
    newpassForm: $("newpass-form"),
    newpassError: $("newpass-error"),
    newpassError2: $("newpass-error-2"),
    
    passModal: $("passModal"),
    cancelBtnModal: $("cancel-pass-modal"),

    //Loader
    loader: $("loader"),

    modalDeleteUser: $("deleteModal"),
    deleteUserBtn: $("delete-user"),
    cancelDeleteUser: $("cancel-delete-user"),

    //Redireccion login y registro
    redir1: $("redir1"),
    redir2: $("redir2"),

    clearChat: $("clear-chat"),
    refreshBtn: $("refresh"),

    //Formulario Contacto
    indexNombre: $("index-nombre"),
    indexEmail: $("index-email"),
    indexMensaje: $("index-mensaje"),

    indexErrorNombre: $("error-index-nombre"),
    indexErrorEmail: $("error-index-email"),
    indexErrorMensaje: $("error-index-mensaje")
};
