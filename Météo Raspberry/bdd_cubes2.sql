#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


#------------------------------------------------------------
# Table: Location
#------------------------------------------------------------

CREATE TABLE Location(
        ID_Location     Int  Auto_increment  NOT NULL ,
        Site            Varchar (50) NOT NULL ,
        GPS_coordinates Varchar (50) NOT NULL
	,CONSTRAINT Location_PK PRIMARY KEY (ID_Location)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Sensor
#------------------------------------------------------------

CREATE TABLE Sensor(
        ID_Sensor   Int  Auto_increment  NOT NULL ,
        Name        Varchar (50) NOT NULL ,
        Description Text ,
        ID_Location Int NOT NULL
	,CONSTRAINT Sensor_PK PRIMARY KEY (ID_Sensor)

	,CONSTRAINT Sensor_Location_FK FOREIGN KEY (ID_Location) REFERENCES Location(ID_Location)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Statement
#------------------------------------------------------------

CREATE TABLE Statement(
        ID_STATEMENT Int  Auto_increment  NOT NULL ,
        Temp         Float NOT NULL ,
        Humidity     Float NOT NULL ,
        Pressure     Float NOT NULL ,
        Time         Datetime NOT NULL ,
        ID_Sensor    Int NOT NULL
	,CONSTRAINT Statement_PK PRIMARY KEY (ID_STATEMENT)

	,CONSTRAINT Statement_Sensor_FK FOREIGN KEY (ID_Sensor) REFERENCES Sensor(ID_Sensor)
)ENGINE=InnoDB;

