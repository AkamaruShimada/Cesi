#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <time.h>
#include <ctype.h>

int count = 0;//le compteur du tab de tous les mots
char tab[2000][26];//tab du chaine de char:2000 colonnes max et chaque colonne contient max 26 char 
char lettre;//lettre qui va entrer le joueur
struct Player//les info des joueurs gagnants 
{
    char nomJoueur[30];
    char score;
};
typedef struct Player player;
void affichageScore()
{

    system("cls");//clear console
        
    printf("____ _____ ______ _   ___      ________ _   _ _    _ ______ \n");
    printf("|  _ \\_   _|  ____| \\ | \\ \\    / /  ____| \\ | | |  | |  ____| \n");
    printf("| |_) || | | |__  |  \\| |\\ \\  / /| |__  |  \\| | |  | | |__    \n");
    printf("|  _ < | | |  __| | . ` | \\ \\/ / |  __| | . ` | |  | |  __|   \n");
    printf("| |_) || |_| |____| |\\  |  \\  /  | |____| |\\  | |__| | |____   \n");
    printf("|____/_____|______|_| \\_|   \\/   |______|_| \\_|\\____/|______|   \n");



    printf("       _ ______ _    _     _____  ______ _   _ _____  _    _ \n");
    printf("      | |  ____| |  | |   |  __ \\|  ____| \\ | |  __ \\| |  | |\n");
    printf("      | | |__  | |  | |   | |__) | |__  |  \\| | |  | | |  | |\n");
    printf("  _   | |  __| | |  | |   |  ___/|  __| | . ` | |  | | |  | |\n");
    printf(" | |__| | |____| |__| |   | |    | |____| |\\  | |__| | |__| |\n");
    printf("  \\____/|______|\\____/    |_|    |______|_| \\_|_____/ \\____/ \n");
                                                             
                                                             

                                                              
                                                              

    player players[2000];//tab de tous les joueurs 
    char bufferMax[1000];//reserver 1000octets pour lecture des lignes du fichier
    FILE *s = fopen("score.txt", "r");//ouvrir le fichier des scores
    if (s == NULL)
    {
        printf("Vous etes le premier joueur!! c'est a vous de marquer le meilleur score!!!");
        return;
    }
    char *token;//lecture du fichier ligne par ligne
    int size = 0;//compteur du tab
    while (fscanf(s, "%s", bufferMax) != EOF)
    {
        player p;//variable de type struct pour pouvoir y acceder
        token = strtok(bufferMax, ":");//découpage du buffer jusquà :
        strcpy(p.nomJoueur,token);//copier dans le nom joueur
        token = strtok(NULL, ":");//découpage 2éme morceau di : jusquà la fin=score
        p.score= token[0];//copier dans le score du joueur(score= token[0]=1seul char=1seul nb)
        players[size] = p;//mettre les lignes dans un tab players 
        size++;//seize compteur du tab players
    }
    fclose(s);
    for(int m=0; m<size-1; m++){ //trier le score top 10 dans le tab players 
        for(int n=m+1; n<size; n++){//n, m compteurs des cases de scores pour pouvoir comparer 
            if(players[m].score < players[n].score){//comparer les scores
                player tri=players[n];//tri varaiable de type player(struct)
                players[n]=players[m];
                players[m]=tri;
            }
        }
    }

    printf("   __  ___    _ ____                                            ____\n");
    printf("  /  |/  /__ (_) / /__ __ _________   ___ _______  _______ ___ / / /\n");
    printf(" / /|_/ / -_) / / / -_) // / __(_-<  (_-</ __/ _ \\/ __/ -_|_-</_/_/ \n");
    printf("/_/  /_/\\__/_/_/_/\\__/\\_,_/_/ /___/ /___/\\__/\\___/_/  \\__/___(_|_)  \n");
                                                         
    printf("               _______________________________________________     \n");
    printf("              |   Nom du joueur            scores             |    \n");   
    printf("              |_______________________________________________|     \n");
                               
    
    for(int m=0; m<size && m<10; m++){
        printf("\n                    %s      ************     %c   ",players[m].nomJoueur,players[m].score); 
    }
   
}
void readF() // lire le fichier et classer tous les mots dans un tableau 
{
    char buffer[1000];//réserver une mémoire de 1000 octets pour le lecture des ligne
    FILE *f = fopen("words.txt", "r");
    if (f == NULL)
    {
        printf("Erreur de lecture du fichier word.txt\n");
        return;
    }
    while (fscanf(f, "%s", buffer) != EOF)//tant que on a pas trouver la fin du fichier
    {
        strcpy(tab[count], buffer);//on copie du buffer jusquà le fin de la ligne (déja on intialisé le compteur compt à 0)
        count++;//il va contunier à avancer et remplir le tab
    }
    fclose(f);
}

char *picW()//choisir un mot au hasard
{
    srand(time(NULL));
    int randomIndex = rand() % count;
    return tab[randomIndex];//mot choisi au hasard
}

void hideW(char *hiddenWord, int t)//remplacer le (mot choisi=pickedWord) par des tirets, le mot deviendra hiddenWord
{
    for (int i = 0; i < t; i++)//parcourir le mot par bouce for de i=0 jusquà t=strlen(pickedWord)(la longueur du mot choisi=pickedW
    {
        hiddenWord[i] = '-';
    }
    hiddenWord[t] = '\0';//ajouter \0 au mot pour limiter longueur sinon il continue d'afficher les lettres dans la mémoire
}

int checkWord(char *pickedWord, char *hiddenWord,int t)//faire le test 
{
    int foundChar = 0;//on a supposé qu'on a pas trouvé lettre dans le mot (=0 càd false)

    for (int foundIndex= 0; foundIndex < t; foundIndex++)// parcourir la lettre de 0 jusqà t(la longueur du mot cherché)
    {
        if (tolower(pickedWord[foundIndex]) == lettre)//si la lettre est dans pickedWord=motcherché,to lower pour rendre tous les char 
        {                                    //du mot choisi en mini puisque la lettre est en mini
            hiddenWord[foundIndex] = pickedWord[foundIndex];//on va remplacer la lettre dans hiddenword=mot à deviner(par les tirets)
            foundChar = 1;//donc on a trouvé la lettre => foundChar devient true
        }
    }
    return foundChar;
}

void echafaud(int compt)//pour afficher le pendu à chaque erreur
{
    switch (compt)//compteur par rapport nombre des tentatives qui ona initialisé 0
    {
    case 1:
        printf("Vous avez perdu une tentative!! Attention, il vous reste que 7\n");
        printf("   _|_       \n");
        printf("  |   |______\n");
        printf("  |          |\n");
        printf("  |__________|\n");
        break;
    case 2:
        printf("vous avez perdu une autre tentative!! il vous reste que 6\n");
        printf("    |      \n");
        printf("    |      \n");
        printf("    |      \n");
        printf("    |      \n");
        printf("    |      \n");
        printf("   _|_       \n");
        printf("  |   |______\n");
        printf("  |          |\n");
        printf("  |__________|\n");
        break;
    case 3:
        printf("vous avez perdu une autre tentative!! il vous reste que 5\n");
        printf("     ____\n");
        printf("    |     \n");
        printf("    |    \n");
        printf("    |   \n");
        printf("    |      \n");
        printf("    |      \n");
        printf("   _|_       \n");
        printf("  |   |______\n");
        printf("  |          |\n");
        printf("  |__________|\n");
        break;
    case 4:
        printf("vous avez perdu une autre tentative!! il vous reste que 4\n");
        printf("     ____\n");
        printf("    |    | \n");
        printf("    |    \n");
        printf("    |    \n");
        printf("    |      \n");
        printf("    |      \n");
        printf("   _|_       \n");
        printf("  |   |______\n");
        printf("  |          |\n");
        printf("  |__________|\n");
        break;
    case 5:
        printf("vous avez perdu une autre tentative!! il vous reste que 3\n");
        printf("     ____\n");
        printf("    |    | \n");
        printf("    |    O\n");
        printf("    |   \n");
        printf("    |      \n");
        printf("    |      \n");
        printf("   _|_       \n");
        printf("  |   |______\n");
        printf("  |          |\n");
        printf("  |__________|\n");
        break;
    case 6:
        printf("vous avez perdu une autre tentative!! il vous reste que 2\n");
        printf("     ____\n");
        printf("    |    | \n");
        printf("    |    O \n");
        printf("    |   / \\\n");
        printf("    |      \n");
        printf("    |      \n");
        printf("   _|_       \n");
        printf("  |   |______\n");
        printf("  |          |\n");
        printf("  |__________|\n");
        break;
    case 7:
        printf("vous avez perdu une autre tentative!! il vous reste qu'une!!ATTENTION\n");
        printf("     ____\n");
        printf("    |    | \n");
        printf("    |    O \n");
        printf("    |   /|\\\n");
        printf("    |    |  \n");
        printf("    |      \n");
        printf("   _|_       \n");
        printf("  |   |______\n");
        printf("  |          |\n");
        printf("  |__________|\n");
        break;
    case 8:
        printf("VOUS ETES PENDU !! :( \n");
        printf("     ____\n");
        printf("    |    | \n");
        printf("    |    O \n");
        printf("    |   /|\\\n");
        printf("    |    |  \n");
        printf("    |   / \\\n");
        printf("   _|_       \n");
        printf("  |   |______\n");
        printf("  |          |\n");
        printf("  |__________|\n");
        break;
    }
}

void main(void)
{
    readF();//lire fichier une seule fois et mettre mot dans untab
    const int nombreTentative = 8;//nb tentative max
    char replay;//char o pour rejouer
    do//le premier do while pour pouvoir rejouer
    {
        int compt = 0;//nomvre de tantive du joueur 
        int tL = 0; // compteur pour le tableau des lettres
        char nomjoueur[30];
        affichageScore();
        printf("\nEntrez le nom du joueur : ");
        scanf("%s", nomjoueur);
        char *pickedWord = picW();
        //printf("%s\n", pickedWord);
        int taille = strlen(pickedWord);
        char hiddenWord[taille+ 1];//le max :taille +1 car on a ajouté un char=\0 au pickedword
        hideW(hiddenWord, taille);
        do//pour répéter les instructions à chaque tentative
        {
            printf("\nLe mot a deviner est compose de %d", taille);
            printf(" caracteres et il est sous la forme de %s", hiddenWord);
            printf("\nVous avez %d tentatives", nombreTentative - compt);//nb tentative restant=nbtentative-compt(qui a perdu)
            printf("\nChoisissez une lettre : ");
            scanf("\n%c", &lettre);
            while (getchar() != '\n');//pour prendre une seule lettre 
            if(isalpha(lettre) != 0){//si le joueur ne propose pas une lettre
                lettre = tolower(lettre);//pour mettre la lettre en minisicule meme quand le joueur la rentre en maj 
                char tabLettre[34];//tab des lettres tentées: le max du tab est à 34=(tentatives+36 le max d'unmot)
                int essaye = 0;// supposant que la lettre n'est pas trouvé dans tab tablettre donc essaye=false(0)
                for (int b = 0; b < tL; b++)
                {
                    if (lettre == tabLettre[b])//si on a trouvé que la lettre était déja tenté 
                    {
                        essaye = 1;
                        break;//on sort 
                    }
                }
                if (essaye == 1)//si on a trouvé lettre dans le tab des lettres déja tentées 
                {
                    printf("\nVous avez deja tente cette lettre");
                }
                else//si la lettre n'est pas trouvé dans le tab des lettres déja tentéés =  une nouvelle lettre on contunie
                {
                    tabLettre[tL] = lettre;//on met les nouvelles lettres dans le tab
                    tL++;
                    int foundChar = checkWord(pickedWord, hiddenWord,taille);//foundchar contient 1 (true) si lettre est trouvée dans le mot
                    if ((foundChar == 0))//si on a pas trouvé lettre dans le mot à deviner
                    {
                        compt++;//le compteur du joueur va augumenter et le nb de tentative va diminuer 
                        echafaud(compt);//desiner le pendu suivant nb tetntive joueur=compt
                    }
                }
            } else printf("\noups!!c'etait pas une lettre!!");  
        } while ((compt < nombreTentative) && (strcmp(pickedWord, hiddenWord) != 0));//il répéte tant que le joueur n'atteint pasnb tentative et iln'a pas trouvé le mot
        if (strcmp(pickedWord, hiddenWord) != 0)//si il n'as pas trouvé le mot 
        {
            printf("\nVous avez perdu :( ");
        }
        else
        {
            printf("\nFelicitations !! vous avez gagne!! :)");
            FILE *fn = fopen("score.txt", "a");//si il a gagné 
            if (fn == NULL)
            {
                printf("\nErreur durant la lecture score.txt");
                return;
            }
            fprintf(fn, "%s:%d\n", nomjoueur, nombreTentative - compt);//on va ecrire le nom du joueur et son score dans fichier score
            fclose(fn);
        }
        printf("\nVoulez-vous rejouer? si OUI tapez o: ");
        scanf(" %c", &replay);
    } while (replay == 'o');
}
