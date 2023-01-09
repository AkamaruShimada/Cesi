#include <stdio.h>
#include <stdlib.h>
#include <time.h>
#include <string.h>
#include <stdbool.h>

char Listemots[2000][30];
char Listeunderscore[2000][30];
char Alphabet[30][5];
int count = 0;

//Lecture du fichier + stockage de la position du mot
void WLoad(char *nomFichier)
{
    char buffer[1000];

    //Lecture
    FILE *f = fopen(nomFichier, "r");
    if (f == NULL) 
    {
        printf("Erreur à l'ouverrture du fichier %s", nomFichier);
    }
    while (fscanf(f, "%s", buffer) != EOF)
    {
        strcpy(Listemots[count], buffer);
        count++;
    }
}
void WLoad2(char *nomFichier2)
{
    char buffer2[1000];

    FILE *f2 = fopen(nomFichier2, "r");
    if (f2 == NULL) 
    {
        printf("Erreur à l'ouverrture du fichier %s", nomFichier2);
    }
    while (fscanf(f2, "%s", buffer2) != EOF)
    {
        strcpy(Alphabet[count], buffer2);
        count++;
    }
}

//Selection random du mot
void *WRan()
{
    srand(time(NULL));
    int c = rand() % count;
    return Listemots[c];
}

//Remplacement par des underscores
void WReplaced(char *Wnfind, int t)
{
    for (int i = 0; i<t; i++)
    {
        Wnfind[i] = '_';
    }
    Wnfind[t] = '\0';
}

//Début du jeu pour trouver les lettres
int WGame()
{
    int Tentatives;
    char Ltenté[30];
    while (Tentatives != 8)
    {
        printf("Propose une lettre : ");
        scanf("%s", Ltenté);
        if(Ltenté)
    }
    printf("Game Over !");
}


//Jeu du pendu
void main(void)
{
    WLoad("words.txt");
    WLoad2("alphabet.txt");
    
    char nom[30];
    printf("Quel est ton nom ?\n");
    printf("Ton nom : ");
    scanf("%s", nom);

    char *Wchosed = WRan();
    printf("%s\n", Wchosed);

    int taille = strlen(Wchosed);
    char Wnfind[taille];
    WReplaced(Wnfind, taille);
    printf("%s\n", Wnfind);

    WGame();

}