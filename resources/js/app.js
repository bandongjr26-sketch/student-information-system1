$(document).ready(function () {
    const csrfToken = $('meta[name="csrf-token"]').attr('content');
    const studentChannel = window.BroadcastChannel ? new BroadcastChannel('students') : null;
    const studentUpdateKey = 'studentsUpdatedAt';

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        }
    });

    if (window.degreeRoutes) {
        setupDegreeAjax();
    }

    if (window.addDegreeRoutes) {
        setupAddDegreeAjax();
    }

    if (window.editDegreeRoutes) {
        setupEditDegreeAjax();
    }

    if (window.studentRoutes) {
        setupStudentListAjax();
    }

    if (window.addStudentRoutes) {
        setupAddStudentAjax();
    }

    if (window.editStudentRoutes) {
        setupEditStudentAjax();
    }

    if (window.addTeacherRoutes) {
        setupAddTeacherAjax();
    }

    if (window.changePasswordRoutes) {
        setupChangePasswordAjax();
    }

    function showAlert(message, type = 'success') {
        $('#degree-alert')
            .removeClass('d-none alert-success alert-danger')
            .addClass(`alert-${type}`)
            .text(message);
    }

    function showStudentAlert(message, type = 'success') {
        if ($('#student-alert').length) {
            $('#student-alert')
                .removeClass('d-none alert-success alert-danger')
                .addClass(`alert-${type}`)
                .text(message);
        } else {
            alert(message);
        }
    }

    function setupDegreeAjax() {
        $('#degree-form').on('submit', function (event) {
            event.preventDefault();

            const degreeId = $('#degree-id').val();
            const isUpdate = Boolean(degreeId);
            const url = isUpdate ? `${window.degreeRoutes.base}/${degreeId}` : window.degreeRoutes.index;
            const data = {
                degree_title: $('#degree_title').val()
            };

            if (isUpdate) {
                data._method = 'PUT';
            }

            $('#degree-title-error').text('');

            $.post(url, data)
                .done(function (response) {
                    showAlert(response.message);
                    clearDegreeForm();
                    loadDegrees();
                })
                .fail(function (xhr) {
                    const errors = xhr.responseJSON?.errors;
                    $('#degree-title-error').text(errors?.degree_title?.[0] ?? 'Unable to save degree.');
                });
        });

        $('#degree-table-body').on('click', '.edit-degree', function () {
            const row = $(this).closest('tr');

            $('#degree-id').val(row.data('id'));
            $('#degree_title').val(row.data('title'));
            $('#degree-title-error').text('');
            $('#save-degree').text('Update Degree').removeClass('btn-success').addClass('btn-primary');
            $('#cancel-edit').removeClass('d-none');
        });

        $('#degree-table-body').on('click', '.delete-degree', function () {
            if (!confirm('Are you sure you want to delete this degree?')) {
                return;
            }

            const degreeId = $(this).closest('tr').data('id');

            $.post(`${window.degreeRoutes.base}/${degreeId}`, { _method: 'DELETE' })
                .done(function (response) {
                    showAlert(response.message);
                    clearDegreeForm();
                    loadDegrees();
                })
                .fail(function () {
                    showAlert('Unable to delete degree.', 'danger');
                });
        });

        $('#cancel-edit').on('click', clearDegreeForm);

        loadDegrees();
    }

    function clearDegreeForm() {
        $('#degree-id').val('');
        $('#degree_title').val('');
        $('#degree-title-error').text('');
        $('#save-degree').text('Add Degree').removeClass('btn-primary').addClass('btn-success');
        $('#cancel-edit').addClass('d-none');
    }

    function renderDegrees(degrees) {
        const rows = degrees.map(function (degree) {
            return `
                <tr data-id="${degree.id}" data-title="${escapeHtml(degree.degree_title)}">
                    <td>${degree.id}</td>
                    <td>${escapeHtml(degree.degree_title)}</td>
                    <td>
                        <button type="button" class="btn btn-primary btn-sm edit-degree">Edit</button>
                        <button type="button" class="btn btn-danger btn-sm delete-degree">Delete</button>
                    </td>
                </tr>
            `;
        });

        $('#degree-table-body').html(
            rows.length ? rows.join('') : '<tr><td colspan="3" class="text-center">No degrees found</td></tr>'
        );
    }

    function escapeHtml(value) {
        return $('<div>').text(value ?? '').html();
    }

    function loadDegrees() {
        $.get(window.degreeRoutes.index)
            .done(function (response) {
                renderDegrees(response.degrees);
            })
            .fail(function () {
                showAlert('Unable to load degrees.', 'danger');
            });
    }

    function setupAddDegreeAjax() {
        $('#saveDegree').on('click', function () {
            $.post(window.addDegreeRoutes.store, {
                degree_title: $('#degree_title').val()
            })
                .done(function (response) {
                    alert(response.message);
                    window.location.href = window.addDegreeRoutes.index;
                })
                .fail(function (xhr) {
                    alert(formatErrors(xhr));
                });
        });
    }

    function setupEditDegreeAjax() {
        $('#updateDegree').on('click', function () {
            const degreeId = $('#degree_id').val();

            $.post(`${window.editDegreeRoutes.base}/${degreeId}`, {
                _method: 'PUT',
                degree_title: $('#degree_title').val()
            })
                .done(function (response) {
                    alert(response.message);
                    window.location.href = window.editDegreeRoutes.index;
                })
                .fail(function (xhr) {
                    alert(formatErrors(xhr));
                });
        });
    }

    function setupStudentListAjax() {
        if (studentChannel) {
            studentChannel.onmessage = function (event) {
                if (event.data === studentUpdateKey || event.data?.type === studentUpdateKey) {
                    loadStudents(false);
                }
            };
        }

        window.addEventListener('storage', function (event) {
            if (event.key === studentUpdateKey) {
                loadStudents(false);
            }
        });

        $(window).on('students-updated', function () {
            if (window.studentRoutes) {
                loadStudents(false);
            }
        });

        $('#student-table-body').on('click', '.delete-student', function () {
            if (!confirm('Are you sure you want to delete this student?')) {
                return;
            }

            const studentId = $(this).data('id');

            $.post(`${window.studentRoutes.base}/${studentId}`, { _method: 'DELETE' })
                .done(function (response) {
                    showStudentAlert(response.message);
                    notifyStudentsUpdated();
                    loadStudents();
                })
                .fail(function () {
                    showStudentAlert('Unable to delete student.', 'danger');
                });
        });

        loadStudents();
    }

    function loadStudents(showError = true) {
        $.get(window.studentRoutes.index)
            .done(function (response) {
                renderStudents(response.students);
            })
            .fail(function () {
                if (showError) {
                    showStudentAlert('Unable to load students.', 'danger');
                }
            });
    }

    function renderStudents(students) {
        const rows = students.map(function (student) {
            const fullName = `${student.lname}, ${student.mname ?? ''}, ${student.fname}`;
            const email = student.user_account?.email ?? 'N/A';
            const degree = student.degree?.degree_title ?? 'N/A';

            return `
                <tr>
                    <td>${escapeHtml(fullName)}</td>
                    <td>${escapeHtml(email)}</td>
                    <td>${escapeHtml(student.contactno)}</td>
                    <td>${escapeHtml(degree)}</td>
                    <td>
                        <a href="${window.studentRoutes.base}/${student.id}" class="btn btn-info btn-sm me-1">View</a>
                        <a href="${window.studentRoutes.base}/${student.id}/edit" class="btn btn-warning btn-sm me-1">Edit</a>
                        <button type="button" class="btn btn-danger btn-sm delete-student" data-id="${student.id}">Delete</button>
                    </td>
                </tr>
            `;
        });

        $('#student-table-body').html(
            rows.length ? rows.join('') : '<tr><td colspan="5" class="text-center">No students found</td></tr>'
        );

        $('#student-list-status').text(`Last table update: ${new Date().toLocaleTimeString()}`);
    }

    function getStudentData() {
        return {
            fname: $('#f_name').val(),
            mname: $('#m_name').val(),
            lname: $('#l_name').val(),
            email: $('#e_mail').val(),
            contactno: $('#contact_no').val(),
            degree_id: $('#degree_id').val(),
            username: $('#username').val(),
            password: $('#password').val(),
            password_confirmation: $('#password_confirmation').val(),
            current_password: $('#current_password').val(),
            new_password: $('#new_password').val(),
            new_password_confirmation: $('#new_password_confirmation').val()
        };
    }

    function formatErrors(xhr) {
        const errors = xhr.responseJSON?.errors;

        if (!errors) {
            return xhr.responseJSON?.message ?? 'Something went wrong.';
        }

        return Object.values(errors).flat().join('\n');
    }

    function notifyStudentsUpdated() {
        const updateTime = Date.now().toString();

        if (studentChannel) {
            studentChannel.postMessage(studentUpdateKey);
            studentChannel.postMessage({
                type: studentUpdateKey,
                updatedAt: updateTime
            });
        }

        localStorage.removeItem(studentUpdateKey);
        localStorage.setItem(studentUpdateKey, updateTime);
        $(window).trigger('students-updated');
    }

    function setupAddStudentAjax() {
        $('#saveStudent').on('click', function () {
            const data = getStudentData();

            if (data.password !== data.password_confirmation || data.password === '') {
                alert('Password and Re-enter Password do not match!');
                return;
            }

            $.post(window.addStudentRoutes.store, data)
                .done(function (response) {
                    notifyStudentsUpdated();
                    alert(response.message);
                    window.location.href = window.addStudentRoutes.index;
                })
                .fail(function (xhr) {
                    alert(formatErrors(xhr));
                });
        });
    }

    function setupEditStudentAjax() {
        $('#updateStudent').on('click', function () {
            const studentId = $('#student_id').val();
            const data = getStudentData();

            data._method = 'PUT';
            delete data.current_password;
            delete data.new_password;
            delete data.new_password_confirmation;

            $.post(`${window.editStudentRoutes.base}/${studentId}`, data)
                .done(function (response) {
                    notifyStudentsUpdated();
                    alert(response.message);
                    window.location.href = window.editStudentRoutes.index;
                })
                .fail(function (xhr) {
                    alert(formatErrors(xhr));
                });
        });
    }

    function setupAddTeacherAjax() {
        $('#saveTeacher').on('click', function () {
            const password = $('#teacher_password').val();
            const passwordConfirmation = $('#teacher_password_confirmation').val();

            if (password !== passwordConfirmation || password === '') {
                alert('Password and Re-enter Password do not match!');
                return;
            }

            $.ajax({
                url: window.addTeacherRoutes.store,
                type: 'POST',
                data: {
                    username: $('#teacher_username').val(),
                    email: $('#teacher_email').val(),
                    password: password,
                    password_confirmation: passwordConfirmation
                },
                success: function (response) {
                    alert(response.message);
                    window.location.href = window.addTeacherRoutes.dashboard;
                },
                error: function (xhr) {
                    alert(formatErrors(xhr));
                }
            });
        });
    }

    function setupChangePasswordAjax() {
        $('#changePasswordBtn').on('click', function () {
            const newPassword = $('#change_new_password').val();
            const newPasswordConfirmation = $('#change_new_password_confirmation').val();

            if (newPassword !== newPasswordConfirmation || newPassword === '') {
                alert('New Password and Re-enter Password do not match!');
                return;
            }

            $.ajax({
                url: window.changePasswordRoutes.update,
                type: 'POST',
                data: {
                    current_password: $('#change_current_password').val(),
                    new_password: newPassword,
                    new_password_confirmation: newPasswordConfirmation
                },
                success: function (response) {
                    alert(response.message);
                    window.location.href = response.redirect;
                },
                error: function (xhr) {
                    alert(formatErrors(xhr));
                }
            });
        });
    }

});
