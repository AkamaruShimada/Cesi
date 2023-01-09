/**
 * @file Untitled-1
 * @author your name (you@domain.com)
 * @brief
 * @version 0.1
 * @date 2022-10-04
 *
 * @copyright Copyright (c) 2022
 *
 */
#include <stdio.h>
#include <stdlib.h>
#include <string.h>

struct _personne
{
    char nom[30];
    char tel[15];
    struct _personne *next;
};

typedef struct _personne Personne;

void add_contact(Personne *liste, Personne *p)
{
    // Chercher le dernier élément
    if (liste == NULL)
    {
        liste = p;
    }
    else
    {
        Personne *current = liste;
        while (current->next != NULL)
        {
            current = current->next;
        }
        current->next = p;
    }
}

void load_contact(char *nomFichier, Personne *liste)
{
    char buffer[1000];
    FILE *f = fopen(nomFichier, "r");
    if (f == NULL)
    {
        printf("Erreur à l'ouverture du fichier %s", nomFichier);
        return;
    }
    char nom[30];
    char tel[15];
    char *token;

    Personne *p;
    p = (Personne*)malloc(sizeof(Personne));

    while (fscanf(f, "%s", buffer) != EOF)
    {
        printf("%s\n", buffer);
        token = strtok(buffer, ";");  
        strcpy(nom, token);
        printf("Nom : %s\t", nom);

        token = strtok(NULL, ";");
        strcpy(tel, token);
        printf("Tel : %s\n", tel);

        add_contact(liste, p);
    }

    fclose(f);
}

/**
 * @brief Affiche le menu et permet la sélection
 *
 *
 * @return N° de la commande sélectionnée
 */
unsigned int menu()
{
    unsigned int c = 0;

    while ((c < 1) || (c > 5))
    {
        printf("\t\tAnnuaire\n");
        printf("1 - Afficher la liste\n");
        printf("2 - Ajouter\n");
        printf("3 - Supprimer\n");
        printf("4 - Rechercher\n");
        printf("5 - Quitter\n");

        printf("Votre choix :");
        scanf("%u", &c);
    }
    return c;
}

void afficher_liste(Personne *liste)
{
    printf("Liste des contacts\n");
    // Affichage de la liste des contacts
    if (liste == NULL)
    {
        printf("Liste des contacts vide\n");
    }
    else
    {
        Personne *current = liste;
        while (current->next != NULL)
        {
            printf("Nom : %s - Tél : %s", current->nom, current->tel);
            current = current->next;
        }
    }
}

void ajouter(Personne *liste)
{
    printf("Ajouter un contact\n");

    // Saisie de la personne
    Personne *p = (Personne *)malloc(sizeof(Personne));
    printf("Nom : ");
    scanf("%s", p->nom);
    printf("Tel : ");
    scanf("%s", p->tel);
    p->next = NULL;

    // Ajouter des contacts
    // Chercher le dernier élément de la liste
    Personne *current = liste;
    if (current = NULL)
    {
    }
}

void supprimer()
{
    printf("Supprimer un contact\n");
    // Supprimer des contacts
}

void rechercher()
{
    printf("Rechercher un contact\n");
    // Rechercher des contacts
}

void quitter()
{
    printf("Quitter\n");
    // Quitter l'annuaire
}

/**
 * @brief Fonction principale
 *
 * @return Code Erreur (0 si pas d'erreur)
 */
int main(void)
{
    Personne *Liste = NULL;
    load_contact("contacts.csv",NULL);

    unsigned int c = 0;
    while (c != 5)
    {
        c = menu();

        switch (c)
        {
        case 1:afficher_liste(Liste);
                break;
        case 2:ajouter(Liste);
                break;
        case 3:supprimer();
                break;
        case 4:rechercher();
                break;
        case 5:quitter();
                break;
        default:break;
        }
    }

    return 0;
}