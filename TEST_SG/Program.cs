//•	Problem 1: 
//o Description
//  	Given a list of people with their birth and end years(all between 1900 and 2000), 
//      find the year with the most number of people alive.
//o Code
//  	Solve using a language of your choice and dataset of your own creation.
//o   Submission
//   Please upload your code, dataset, and example of the program’s output to Bit Bucket or Github.
//    Please include any graphs or charts created by your program.


using System;
using System.Collections.Generic;
using System.Linq;

namespace TEST_SG
{
    class Program
    {
        static void Main(string[] args)
        {
            Random rnd = new Random();
            int BirthYear;
            int Result = 0;
            List<int> Birth = new List<int>();
            List<int> End = new List<int>();
            List<int> year = new List<int>();
            Console.WriteLine("Enter the number of people");
            int noOfPeople = Convert.ToInt32(Console.ReadLine());
            Console.WriteLine("\n\nYear\tNo.of People Alive");

            // Randomly generating birth and end year of the person
            for (int i = 0; i < noOfPeople; i++)
            {   // year 1900 and 2000 are included
                BirthYear = rnd.Next(1900, 2001); //birth year of a person n
                Birth.Add(BirthYear);
                End.Add(rnd.Next(BirthYear, 2001)); // death year should be greater than birth year of a person n 
            }
            //checking No. of people live in each year
            for (int i = 1900; i < 2001; i++) 
            {
                for (int j = 0; j < noOfPeople; j++) {
                    if (i >= Birth[j] && i <= End[j]) { // birth and end year of the person included
                        Result += 1;
                    }
                }
                year.Add(Result);
                Result = 0;
                Console.WriteLine((i) + "\t" + year[(i - 1900)]); 
            }
            Result = (1900 + year.IndexOf(year.Max()));
            //returns the first year in the result
            Console.WriteLine("\n\n"+ Result + " is the year with the most number of people alive");
            Console.ReadLine();
        }
    }
}
