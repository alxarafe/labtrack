<?php

use Alxarafe\Lib\Router;

// LabTrack Routes
Router::add('home', '/', 'LabTrack.Main.index');
Router::add('admin_login', '/auth/login', 'Admin.Auth.login');
Router::add('admin_logout', '/auth/logout', 'Admin.Auth.logout');
Router::add('login', '/login', 'LabTrack.Main.login');
Router::add('logout', '/logout', 'LabTrack.Main.logout');
Router::add('order_select', '/order', 'LabTrack.Main.selectOrder');
Router::add('center_select', '/center', 'LabTrack.Main.selectCenter');
Router::add('family_select', '/center/{centerId}/families', 'LabTrack.Main.selectFamily');
Router::add('process_select', '/family/{familyId}/processes', 'LabTrack.Main.selectProcess');
Router::add('sequence_select', '/process/{processId}/sequences', 'LabTrack.Main.selectSequence');
Router::add('record_movement', '/record', 'LabTrack.Main.record');
Router::add('orders', '/orders', 'LabTrack.Order.index');

// Configuration
Router::add('config', '/configuracion', 'LabTrack.Config.index');
Router::add('config_users', '/configuracion/usuarios', 'LabTrack.Config.users');
Router::add('config_users_save', '/configuracion/usuarios/save', 'LabTrack.Config.saveUsers');
Router::add('config_centers', '/configuracion/centros', 'LabTrack.Config.centers');
Router::add('config_centers_save', '/configuracion/centros/save', 'LabTrack.Config.saveCenters');
Router::add('config_families', '/configuracion/familias', 'LabTrack.Config.families');
Router::add('config_families_save', '/configuracion/familias/save', 'LabTrack.Config.saveFamilies');
Router::add('config_processes', '/configuracion/procesos', 'LabTrack.Config.processes');
Router::add('config_processes_families', '/configuracion/procesos/{processId}', 'LabTrack.Config.processes');
Router::add('config_processes_save', '/configuracion/procesos/save', 'LabTrack.Config.saveProcesses');
Router::add('config_processes_families_save', '/configuracion/procesos/{processId}/save', 'LabTrack.Config.saveProcessFamilies');
Router::add('config_sequences', '/configuracion/secuencias', 'LabTrack.Config.sequences');
Router::add('config_sequences_processes', '/configuracion/secuencias/{sequenceId}', 'LabTrack.Config.sequences');
Router::add('config_sequences_save', '/configuracion/secuencias/save', 'LabTrack.Config.saveSequences');
Router::add('config_sequences_processes_save', '/configuracion/secuencias/{sequenceId}/save', 'LabTrack.Config.saveSequenceProcesses');

// Supervision
Router::add('supervision', '/supervision', 'LabTrack.Report.validate'); // Temporary mapping or create new

// Reports
Router::add('reports', '/reports', 'LabTrack.Report.index');
Router::add('reports_user', '/reports/user', 'LabTrack.Report.user');
Router::add('reports_order', '/reports/order', 'LabTrack.Report.order');
Router::add('reports_validate', '/reports/validate', 'LabTrack.Report.validate');
