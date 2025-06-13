ALTER TABLE `task`
ADD COLUMN `idUsuarioAsignado` INT(11) DEFAULT NULL,
ADD CONSTRAINT `fk_task_usuario_asignado`
  FOREIGN KEY (`idUsuarioAsignado`) REFERENCES `usuario`(`id`)
  ON DELETE SET NULL ON UPDATE CASCADE;


--tasks consulta


SELECT 
        task.*, 
        usuario.nombre AS nombreAsignado, 
        usuario.apellidos AS apellidosAsignado
    FROM task
    LEFT JOIN usuario ON task.idUsuarioAsignado = usuario.id
    WHERE task.idProyecto = :idProyecto


