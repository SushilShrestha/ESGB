table should be manually created.
each table should have a model class linked. each model class can have a constructor that calls the constructor of parent model class and the argument list should have default value as empty string and before initializing the properties the default arguments is to be checked.
each table should compulsary have an id field. The id field is used in updateDB() function. if the result is not as you desire then issue custom sql command using executeSQL(sqlCommandToExecute).
properties(variables) of the model class should only include the field names or else it will create problem in addToDB() function.
each model class should have getFields() function returning the namelist of the fields.