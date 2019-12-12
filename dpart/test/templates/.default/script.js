$(function () {

    /**
     * Ajax запрос к компоненте
     * @returns {*}
     * @param name
     * @param data
     */
    function action(name, data) {
        return BX.ajax.runComponentAction(BX.message('TEST_COMPONENT_NAME'), name, {
            mode: 'class',
            data: data,
        });
    }

    /**
     * Вывод сообщений об ошибке ввода
     * @param res
     */
    function alertErrors(res) {
        alert(res.errors.map(function (v) {
            return v.message;
        }).join("\n"));
    }

    /**
     * Функция для события отправки формы
     * @param e
     */
    function submitEvent(e) {
        e.preventDefault();
        action('add', {
            highLoadBlockId: BX.message('TEST_COMPONENT_HIGHLOADBLOCKID'),
            name: $(this).find("[name=name]").val(),
            year: $(this).find("[name=year]").val(),
            author: $(this).find("[name=author]").val(),
            desc: $(this).find("[name=desc]").val(),
        }).then(function (res) {
            reload();
        }).catch(alertErrors);
    }

    /**
     * Функция для события удаления
     */
    function deleteEvent() {
        var id = $(this).parent().parent().data('id');
        action('delete', {
            highLoadBlockId: BX.message('TEST_COMPONENT_HIGHLOADBLOCKID'),
            id: id,
        }).then(function (res) {
            reload();
        }).catch(alertErrors);
    }

    /**
     * Навешиваем события
     */
    function addEvents() {
        $(".books_cont .books_action_delete").click(deleteEvent);
        $(".books_cont .books_form").submit(submitEvent);
    }

    /**
     * Перезагружаем область и навешиваем события
     */
    function reload() {
        $(".books_cont").load(location.pathname + '?is_ajax=y', function () {
            addEvents();
        });
    }

    addEvents();
});
