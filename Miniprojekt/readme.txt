---------- ---------- ---------- Misc ---------- ---------- ----------

The files which should only be opened by users are the php files, which are in the php folder.

Remember that if you reset the SQL tables you may be wish to reset "id_gen.txt" to just containing "1",
The file is found in the "txt" folder.

---------- ---------- ---------- SQL ---------- ---------- ----------
Database: Miniprojekt

    these are needed:

        (stores account)
        create table accounts(
            id int(16) AUTO_INCREMENT,
            username varchar(256),
            password varchar(256),
            time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            KEY (id)
        )

        (stores a list of all the forms)
        create table forms(
            id int(255),
            title varchar(256),
            description varchar(1024),
            user varchar(256),
            time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            KEY (id)
        )

Database: Miniprojekt_forms

    make table which coresponds to new forms, these are auto generated in createForm.php ;
    so do not create this table, although the database is required

    create table x(
        id int(16) AUTO_INCREMENT,
        title varchar(256),
        description varchar(1024),
        user varchar(256),
        time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
        KEY (id)
    )

---------- ---------- ---------- PHP ---------- ---------- ----------
This is the meathod used to encrypt and decrypt passwords:

    Algoritm: "AES-128-ECB"
    Passphrase: "aBHF65aBtG5"

    // encrypt $string_to_encrypt:
        $encrypted_string = openssl_encrypt($string_to_encrypt,"AES-128-ECB","aBHF65aBtG5");

    // decrypt $encrypted_string:
        $decrypted_string = openssl_decrypt($encrypted_string,"AES-128-ECB","aBHF65aBtG5");
